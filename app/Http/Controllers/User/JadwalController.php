<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class JadwalController extends Controller
{

    public function index()
    {
        $now = now();

        // ubah status booking yang sudah lewat menjadi "finished"
        Booking::where('user_id', Auth::id())
            ->where('status', 'active')
            ->where(function ($query) use ($now) {
                $query->where('tanggal_booking', '<', $now->toDateString())
                    ->orWhere(function ($q) use ($now) {
                        $q->where('tanggal_booking', $now->toDateString())
                            ->where('jam_selesai', '<', $now->format('H:i:s'));
                    });
            })->update(['status' => 'finished']);

        $bookings = Booking::with('ruang')
            ->where('user_id', Auth::id())
            ->where('status', 'active')
            ->orderByDesc('tanggal_booking')
            ->orderByDesc('jam_mulai')
            ->get();

        return view('user.jadwal.index', compact('bookings'));
    }


    public function create()
    {
        //
    }

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

    public function destroy(string $id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // cek booking sudah lewat atau belum
        if ($booking->tanggal_booking < now()->toDateString()) {
            return redirect()->back()->withErrors(['msg' => 'Booking sudah lewat dan tidak bisa dibatalkan.']);
        }

        // Hanya boleh batalkan kalau statusnya masih active
        if ($booking->status !== 'active') {
            return redirect()->back()->withErrors(['msg' => 'Booking ini sudah tidak aktif.']);
        }

        $booking->status = 'cancelled';
        $booking->save();

        return redirect()->route('user.jadwal.index')->with('success', 'Booking berhasil dibatalkan.');
    }

    public function riwayat()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->whereIn('status', ['finished', 'cancelled'])
            ->orderByDesc('tanggal_booking')
            ->orderByDesc('jam_mulai')
            ->get();

        return view('user.jadwal.riwayat', compact('bookings'));
    }

}
