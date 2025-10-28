<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $bulan = $request->input('bulan');

        $query = Booking::with(['user', 'ruang'])->whereIn('status', ['finished', 'rejected']);

        if ($tanggal) {
            $query->whereDate('tanggal', $tanggal);
        }

        if ($bulan) {
            $query->whereMonth('tanggal', date('m', strtotime($bulan)))
                ->whereYear('tanggal', date('Y', strtotime($bulan)));
        }

        $bookings = $query->get();

        $totalPenggunaan = Booking::whereIn('status', ['finished', 'rejected'])->count();
        $totalUser = Booking::whereIn('status', ['finished', 'rejected'])->distinct('user_id')->count('user_id');
        $totalBatal = Booking::where('status', 'rejected')->count();

        return view('admin.laporan.index', compact('bookings', 'totalPenggunaan', 'totalUser', 'totalBatal'));
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
    public function laporanBooking(Request $request)
    {
        $query = Booking::query()->with('ruang', 'user');

        if ($request->tanggal_mulai && $request->tanggal_akhir) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir]);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->get();

        return view('admin.laporan.booking', [
            'bookings' => $bookings,
            'totalPenggunaan' => $query->count(),
            'totalUser' => $query->distinct('user_id')->count(),
            'totalBatal' => $query->where('status', 'rejected')->count(),
        ]);
    }   

}
