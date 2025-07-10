<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Ruang;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todayBooking = Booking::whereDate('tanggal_booking', now())->count();
        $totalRuangan = \App\Models\Ruang::count();

        // Statistik Booking per bulan
        $bookingPerBulan = Booking::selectRaw('MONTH(tanggal_booking) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_booking', now()->year)
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        // Isi 12 bulan
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $bookingPerBulan[$i] ?? 0;
        }

        return view('admin.dashboard', compact('todayBooking', 'totalRuangan', 'chartData'));
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
