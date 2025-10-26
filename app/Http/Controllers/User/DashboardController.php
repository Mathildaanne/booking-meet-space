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

        $bookingAktif = Booking::where('user_id', $user->id)
            ->where(function ($q) {
                $q->where('tanggal_booking', '>', Carbon::today())
                ->orWhere(function ($sub) {
                    $sub->where('tanggal_booking', Carbon::today())
                        ->where('jam_selesai', '>', Carbon::now()->format('H:i'));
                });
            })
            ->whereIn('status', ['active'])
            ->count();

        $upcoming = Booking::with('ruang')
            ->where('user_id', $user->id)
            ->where(function ($query) {
                $query->where('tanggal_booking', '>', Carbon::today())
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('tanggal_booking', Carbon::today())
                            ->where('jam_mulai', '>', Carbon::now()->format('H:i'));
                    });
            })
            ->where('status', 'active')
            ->orderBy('tanggal_booking')
            ->orderBy('jam_mulai')
            ->limit(5)
            ->get();

        return view('user.dashboard', compact( 'bookingAktif','upcoming'));
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
