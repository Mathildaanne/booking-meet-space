<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $jumlahBooking = Booking::where('user_id', $user->id)->count();

        $upcoming = Booking::with('ruang')
            ->where('user_id', $user->id)
            ->where('tanggal_booking', '>=', now()->toDateString())
            ->orderBy('tanggal_booking')
            ->first();

        // Statistik booking per bulan (Januari–Desember)
        $bookingPerBulan = Booking::selectRaw('MONTH(tanggal_booking) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_booking', now()->year)
            ->where('user_id', $user->id)
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        // Siapkan array lengkap 12 bulan (0 jika tidak ada booking)
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $bookingPerBulan[$i] ?? 0;
        }

        return view('user.dashboard', compact('jumlahBooking', 'upcoming', 'chartData'));
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
    public function show(string $id)
    {
        //
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
        //
    }
}
