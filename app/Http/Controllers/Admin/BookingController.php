<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Models\Ruang;
use App\Notifications\BookingCanceled;


class BookingController extends Controller
{

    public function index()
    {
        $bookings = Booking::with(['user', 'ruang'])
            ->where('status', 'active') 
            ->latest()
            ->get();

        return view('admin.booking.index', compact('bookings'));
    }

    public function detail($id)
    {
        $booking = Booking::with(['user', 'ruang'])->findOrFail($id);
        return view('admin.booking.show', compact('booking'));
    }

    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Data booking berhasil dihapus.');
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function reject(Request $request, $id)
    {
        $booking = Booking::with('ruang', 'user')->findOrFail($id);

        $request->validate([
            'alasan_pembatalan' => 'required|string|max:255',
        ]);

        $booking->status = 'rejected';
        $booking->alasan_pembatalan = $request->alasan_pembatalan;
        $booking->save();

        $booking->user->notify(new BookingCanceled($booking));

        return redirect()->back()->with('success', 'Booking berhasil ditolak.');
    }
}

    