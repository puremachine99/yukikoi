<?php

namespace App\Http\Controllers;

use App\Models\UserAdress;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $addresses = $user->addresses;
        $editAddress = null;

        if ($request->has('edit')) {
            $editAddress = $user->addresses()->findOrFail($request->get('edit'));
        }

        return view('profile.partials.addresses', compact('addresses', 'editAddress'));
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
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'full_address' => 'required|string',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'type' => 'nullable|string|in:rumah,kantor,lain-lain',
            'is_default' => 'nullable|boolean',
        ]);

        if ($validated['is_default'] ?? false) {
            auth()->user()->addresses()->update(['is_default' => false]);
        }

        auth()->user()->addresses()->create($validated);

        return back()->with('status', 'Alamat berhasil ditambahkan!');
    }



    /**
     * Display the specified resource.
     */
    public function show(UserAdress $userAdress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserAddress $address)
    {
        // Validasi data
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'full_address' => 'required|string',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'type' => 'nullable|string|in:rumah,kantor,lain-lain',
            'is_default' => 'nullable|boolean',
        ]);

        // Jika alamat di-set sebagai default, hapus default dari alamat lain
        if ($validated['is_default'] ?? false) {
            auth()->user()->addresses()->update(['is_default' => false]);
        }

        // Perbarui alamat
        $address->update($validated);

        return back()->with('status', 'Alamat berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserAddress $address)
    {
        // Pastikan alamat milik user yang sedang login
        if ($address->user_id !== auth()->id()) {
            abort(403, 'Anda tidak diizinkan menghapus alamat ini.');
        }

        // Hapus alamat
        $address->delete();

        return back()->with('status', 'Alamat berhasil dihapus.');
    }



    public function setDefault($id)
    {
        // Ambil alamat yang akan dijadikan default milik user saat ini
        $address = UserAddress::where('user_id', auth()->id())->findOrFail($id);

        // Reset semua alamat agar tidak default
        UserAddress::where('user_id', auth()->id())->update(['is_default' => false]);

        // Set alamat yang dipilih sebagai default
        $address->update(['is_default' => true]);

        return back()->with('success', 'Alamat default berhasil diatur.');
    }
}
