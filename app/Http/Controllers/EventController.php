<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Koi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of all event.
     */
    public function index(Request $request)
    {
        // Query dasar untuk mengambil semua event
        $query = Event::query();

        // Filter berdasarkan tipe event, jika ada
        if ($request->has('event_type')) {
            $query->where('event_type', $request->input('event_type'));
        }

        // Filter berdasarkan status, jika ada
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        // Ambil semua event dengan pagination
        $events = $query->orderBy('start_time', 'asc')->get();

        // Proses untuk mengelompokkan event berdasarkan nama "folder"
        $groupedEvents = $events->groupBy(function ($event) {
            // Cek apakah ada " - Part " dalam event_name
            if (preg_match('/(.*?) - Part \d+$/', $event->event_name, $matches)) {
                return $matches[1]; // Ambil nama event utama
            }
            return $event->event_name; // Event tanpa part dianggap event utama
        });

        // Return ke view dengan data grouped events
        return view('event.index', compact('groupedEvents'));
    }


    /**
     * List all events created by the authenticated user.
     */
    public function list($eventId = null)
    {
        // Ambil data koi berdasarkan ID event
        $koi = Koi::where('id', $eventId)->paginate(10);

        // Return ke view list koi
        return view('koi.index', compact('koi'));
    }


    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        return view('event.create');
    }

    /**
     * Store a newly created event in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'description' => 'required|string',
            'event_type' => 'required|in:keeping contest,grow out,azukari',
            'reward_mode' => 'required|in:percent,fixed',
            'submission_time' => 'required|date',
            'judging_time' => 'required|date',
            'start_time' => 'required|array',
            'start_time.*' => 'required|date',
            'end_time' => 'required|array',
            'end_time.*' => 'required|date',
            'nomination' => 'nullable|array',
            'nomination.*' => 'nullable|string',
            'reward_percentage' => 'nullable|array',
            'reward_percentage.*' => 'nullable|numeric',
            'fixed_nomination' => 'nullable|array',
            'fixed_nomination.*' => 'nullable|string',
            'fixed_nominal' => 'nullable|array',
            'fixed_nominal.*' => 'nullable|numeric',
            'banner' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        // Upload banner file
        $bannerPath = null;
        if ($request->hasFile('banner')) {
            $bannerFile = $request->file('banner');
            $bannerPath = $bannerFile->store('banners', 'public');
        }

        // Prepare event parts
        $rewardData = $this->prepareRewardData($request);
        $eventParts = $this->prepareEventParts($request, $rewardData, $bannerPath, $user);

        // Save events
        Event::insert($eventParts);

        return redirect()->route('event.index')->with('success', 'Event created successfully with multiple parts!');
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        return view('event.show', compact('event'));
    }

    /**
     * Show the form for editing an event.
     */
    public function edit(Event $event)
    {
        return view('event.edit', compact('event'));
    }

    /**
     * Update the specified event.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'event_type' => 'required|in:keeping contest,grow out,azukari',
            'reward_mode' => 'required|in:percent,fixed',
            'submission_time' => 'required|date',
            'judging_time' => 'required|date',
        ]);

        $event->update($request->all());
        return redirect()->route('event.index')->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified event from the database.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('event.list')->with('success', 'Event deleted successfully!');
    }

    /**
     * Prepare reward data.
     */
    private function prepareRewardData(Request $request)
    {
        $rewardData = [];

        if ($request->reward_mode === 'percent') {
            foreach ($request->nomination as $key => $nomination) {
                $rewardData[] = [
                    'nomination' => $nomination,
                    'reward_percentage' => $request->reward_percentage[$key] ?? null,
                ];
            }
        } else {
            foreach ($request->fixed_nomination as $key => $nomination) {
                $rewardData[] = [
                    'nomination' => $nomination,
                    'reward_nominal' => $request->fixed_nominal[$key] ?? null,
                ];
            }
        }

        return $rewardData;
    }

    /**
     * Prepare event parts for insertion.
     */
    private function prepareEventParts(Request $request, $rewardData, $bannerPath, $user)
    {
        $eventParts = [];
        $startTimes = $request->start_time;
        $endTimes = $request->end_time;

        foreach ($startTimes as $index => $startTime) {
            $eventCode = $this->generateEventCode($request->event_type, $index);

            $eventParts[] = [
                'event_name' => $request->event_name . " - Part " . ($index + 1),
                'description' => $request->description,
                'event_type' => $request->event_type,
                'reward_mode' => $request->reward_mode,
                'total_reward' => $request->total_reward ?? null,
                'fixed_reward_total' => $request->fixed_reward_total ?? null,
                'submission_time' => $request->submission_time,
                'judging_time' => $request->judging_time,
                'start_time' => $startTime,
                'end_time' => $endTimes[$index],
                'doorprize' => $request->doorprize,
                'approval_code' => null,
                'approved_by' => null,
                'approved_at' => null,
                'reward_data' => json_encode($rewardData),
                'banner' => $bannerPath,
                'status' => 'pending',
                'created_by' => $user->id,
                'event_code' => $eventCode,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        return $eventParts;
    }

    /**
     * Generate a unique event code.
     */
    private function generateEventCode($eventType, $index)
    {
        $prefix = strtoupper(substr($eventType, 0, 2));
        $year = now()->format('y');
        $month = now()->format('m');
        $eventCount = Event::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count() + 1;

        return sprintf('%s%s%s%03d-%d', $prefix, $year, $month, $eventCount, $index + 1);
    }
}
