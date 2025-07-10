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

        $query = Booking::query();

        if ($tanggal) {
            $query->whereDate('tanggal_booking', $tanggal);
        } elseif ($bulan) {
            $query->whereMonth('tanggal_booking', Carbon::parse($bulan)->month)
                  ->whereYear('tanggal_booking', Carbon::parse($bulan)->year);
        }

        $rekap = $query->select('ruang_id', DB::raw('COUNT(*) as total'))
                    ->groupBy('ruang_id')
                    ->with('ruang')
                    ->get();

        return view('admin.laporan.index', compact('rekap', 'tanggal', 'bulan'));
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
