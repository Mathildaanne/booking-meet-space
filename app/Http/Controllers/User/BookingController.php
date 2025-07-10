<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking; 
use App\Models\Ruang; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() { 
        $ruangans = Ruang::all();
        $bookedRuangIds = Booking::where('user_id', Auth::id())
            ->where('tanggal_booking', now()->toDateString())
            ->pluck('ruang_id')
            ->toArray();

        return view('user.booking.index', compact('ruangans', 'bookedRuangIds'));    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $ruang_id) { 
        $ruang = Ruang::findOrFail($ruang_id);
        // Ambil tanggal dari query, atau default ke hari ini
        $selectedDate = $request->input('tanggal', Carbon::today()->toDateString());

        // Ambil semua booking pada tanggal tersebut
        $bookings = Booking::where('ruang_id', $ruang_id)
            ->where('tanggal_booking', $selectedDate)
            ->orderBy('jam_mulai')
            ->get();

        return view('user.booking.create', compact('ruang', 'bookings', 'selectedDate'));    
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) { 
        $request->validate([ 
            'ruang_id' => 'required|exists:ruangs,id',
            'tanggal_booking' => 'required|date|after_or_equal:today', 
            'jam_mulai' => 'required|date_format:H:i', 
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai', 
            'nama' => 'required|string|max:255',
            'jumlah_orang' => 'required|integer|min:1',
            'keperluan' => 'nullable|string',
        ]);  
        
        $day = Carbon::parse($request->tanggal_booking)->format('N'); 
        if ($day >= 6) { 
            return back()->withErrors(['tanggal_booking' => 'Booking hanya bisa dilakukan pada hari kerja (Senin–Jumat).']); 
        } 
        
        $isAvailable = Booking::where('ruang_id', $request->ruang_id) 
        ->where('tanggal_booking', $request->tanggal_booking) 
        ->where(function ($query) use ($request) { 
        $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai]) 
            ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai]) 
            ->orWhere(function ($q) use ($request) { $q->where('jam_mulai', '<=', $request->jam_mulai) 
            ->where('jam_selesai', '>=', $request->jam_selesai); }); 
        }) 
            
        ->whereIn('status', ['approved', 'pending']) 
        ->exists(); if ($isAvailable) { 
            return back()->withErrors(['jam_mulai' => 'Waktu yang dipilih sudah digunakan untuk ruangan ini.']); 
        } 
        Booking::create([
            'user_id' => Auth::id(),
            'ruang_id' => $request->ruang_id, // ✅ ambil dari request, bukan string aturan
            'tanggal_booking' => $request->tanggal_booking,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'nama' => $request->nama,
            'jumlah_orang' => $request->jumlah_orang,
            'keperluan' => $request->keperluan,
            'status' => 'pending',
        ]);
                            
        return redirect()->route('bookings.index')->with('success', 'Booking berhasil dibuat.'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking) 
    {
         return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) { 
            abort(403); 
        } 
        
        $ruang = Ruang::all(); 
        return view('bookings.edit', compact('booking', 'ruang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) { 
            abort(403); 
        } 
        
        $booking->delete(); 
        return redirect()->route('bookings.index')->with('success', 'Booking dibatalkan.'); 
    }
}
