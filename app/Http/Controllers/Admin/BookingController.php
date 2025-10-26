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
    /**
     * Tampilkan daftar booking.
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'ruang'])
            ->where('status', 'active') 
            ->latest()
            ->get();

        return view('admin.booking.index', compact('bookings'));
    }


    /**
     * Tampilkan detail booking tertentu.
     */
    public function detail($id)
    {
        $booking = Booking::with(['user', 'ruang'])->findOrFail($id);
        return view('admin.booking.show', compact('booking'));
    }

    /**
     * Hapus data booking.
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Data booking berhasil dihapus.');
    }

    // Tambahan metode jika dibutuhkan:
    public function create()
    {
        // Tampilkan form jika membuat booking via admin (opsional)
    }

    public function store(Request $request)
    {
        // Validasi dan simpan booking
    }

    public function edit($id)
    {
        // Tampilkan form edit
    }

    public function update(Request $request, $id)
    {
        // Validasi dan update booking
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

        // Kirim notifikasi ke user
        $booking->user->notify(new BookingCanceled($booking));

        return redirect()->back()->with('success', 'Booking berhasil ditolak.');
    }
}

    