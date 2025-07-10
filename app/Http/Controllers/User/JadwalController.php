<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with('ruang')
            ->where('user_id', Auth::id())
            ->orderBy('tanggal_booking', 'desc')
            ->get();

        return view('user.jadwal.index', compact('bookings'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $booking = Booking::with('ruang')->where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('user.jadwal.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking = Booking::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Boleh dibatalkan hanya jika status belum 'done' dan belum lewat waktunya
        if ($booking->tanggal_booking < now()->toDateString()) {
            return redirect()->back()->withErrors(['msg' => 'Booking sudah lewat dan tidak bisa dibatalkan.']);
        }

        $booking->delete();

        return redirect()->route('user.jadwal.index')->with('success', 'Booking berhasil dibatalkan.');
    }
}
