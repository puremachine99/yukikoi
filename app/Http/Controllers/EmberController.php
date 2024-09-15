<?php

namespace App\Http\Controllers;

use App\Models\Ember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $koiId = $request->koi_id;

        // Check if koi is already marked by the user
        $exists = Ember::where('user_id', $user->id)
            ->where('koi_id', $koiId)
            ->exists();

        if (!$exists) {
            Ember::create([
                'user_id' => $user->id,
                'koi_id' => $koiId,
            ]);

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'already_marked']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ember $ember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ember $ember)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ember $ember)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ember $ember)
    {
        //
    }
}
