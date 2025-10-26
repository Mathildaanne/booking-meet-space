<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Ruang;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = now()->toDateString();
        $now = now()->format('H:i:s');
        
        // Semua data statistik
        $totalUsers = User::count();
        $totalBooking = Booking::count();
        $totalRuangan = Ruang::count();
        $todayBooking = Booking::whereDate('tanggal_booking', $today)->count();

        // Jadwal hari ini yang masih aktif (jam_selesai > sekarang)
        $todaySchedules = Booking::with(['user', 'ruang'])
            ->whereDate('tanggal_booking', $today)
            ->where('jam_selesai', '>', $now) // hanya yang belum selesai
            ->orderBy('jam_mulai')
            ->get();

        // Statistik Booking per bulan
        $bookingPerBulan = Booking::selectRaw('MONTH(tanggal_booking) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_booking', now()->year)
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $bookingPerBulan[$i] ?? 0;
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalBooking',
            'totalRuangan',
            'todayBooking',
            'todaySchedules',
            'chartData'
        ));

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
