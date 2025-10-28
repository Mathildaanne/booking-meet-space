<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking; 
use App\Models\Ruang; 
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Notifications\BookingCreated;
use Illuminate\Support\Facades\Notification;


class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() { 
        $ruangans = Ruang::all();
        $ruanganDipakai = Booking::where('user_id', Auth::id())
            ->where('tanggal_booking', now()->toDateString())
            ->pluck('ruang_id')
            ->toArray();

        return view('user.booking.index', compact('ruangans', 'ruanganDipakai'));    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $ruang_id) { 
        $ruang = Ruang::findOrFail($ruang_id);
        $selectedDate = $request->input('tanggal', Carbon::today()->toDateString());

        $now = Carbon::now();

        $bookings = Booking::where('ruang_id', $ruang_id)
            ->where('tanggal_booking', $selectedDate)
            ->where('status', 'active') 
            ->when($selectedDate === $now->toDateString(), function ($query) use ($now) {
                $query->where('jam_selesai', '>=', $now->format('H:i:s'));
            })
            ->when($selectedDate < $now->toDateString(), function ($query) {
                $query->whereRaw('1 = 0');
            })
            ->orderBy('jam_mulai')
            ->get();

            
        return view('user.booking.create', compact('ruang', 'bookings', 'selectedDate'));

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) { 
        $request->validate([ 
            'ruang_id'        => 'required|exists:ruangs,id',
            'tanggal_booking' => 'required|date|after_or_equal:today|before_or_equal:' 
                                    . now()->addDays(30)->toDateString(),
            'jam_mulai'       => 'required|date_format:H:i', 
            'jam_selesai'     => 'required|date_format:H:i|after:jam_mulai', 
            'nama'            => 'required|string|max:255',
            'jumlah_orang'    => 'required|integer|min:1',
            'keperluan'       => 'nullable|string',
        ], [
            'tanggal_booking.before_or_equal' => 'Tanggal booking harus berupa tanggal sebelum atau sama dengan ' 
                                                    . now()->addDays(30)->translatedFormat('d F Y'),
            'tanggal_booking.after_or_equal'  => 'Tanggal booking tidak boleh sebelum hari ini.',
            'jam_mulai.after'                 => 'Jam mulai harus sebelum jam selesai.',
            'jam_selesai.after'               => 'Jam selesai harus setelah jam mulai.',
        ]);
  
        $ruang = Ruang::findOrFail($request->ruang_id);
        
        $day = Carbon::parse($request->tanggal_booking)->format('N'); 
        if ($day >= 6) { 
            return back()->withErrors(['tanggal_booking' => 'Booking hanya bisa dilakukan pada hari kerja (Senin–Jumat).'
            ])->withInput(); 
        } 

        $jamMulai   = Carbon::parse($request->jam_mulai);
        $jamSelesai = Carbon::parse($request->jam_selesai);
        $jamBuka    = Carbon::parse($ruang->jam_buka);
        $jamTutup   = Carbon::parse($ruang->jam_tutup);

        
        if ($request->jam_mulai < $ruang->jam_buka) {
            return back()->withErrors([
                'jam_mulai' => 'Jam mulai harus setelah jam operasional buka: ' .
                            Carbon::parse($ruang->jam_buka)->format('H:i')
            ])->withInput();
        }

        if ($request->jam_selesai > $ruang->jam_tutup) {
            return back()->withErrors([
                'jam_selesai' => 'Jam selesai harus sebelum jam operasional tutup: ' .
                            Carbon::parse($ruang->jam_tutup)->format('H:i')
            ])->withInput();
        }

        $isAvailable = Booking::where('ruang_id', $request->ruang_id)
            ->where('tanggal_booking', $request->tanggal_booking)
            ->where(function ($query) use ($request) {
                $query->where('jam_mulai', '<', $request->jam_selesai)
                    ->where('jam_selesai', '>', $request->jam_mulai);
            })
            ->exists();

        if ($isAvailable) {
            logger('Booking bentrok:', [
                'ruang_id' => $request->ruang_id,
                'tanggal' => $request->tanggal_booking,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
            ]);
            return back()->withErrors([
                'jam_mulai' => 'Waktu yang dipilih sudah digunakan untuk ruangan ini.'])
                ->withInput();
        }



        $booking = Booking::create([
            'user_id' => Auth::id(),
            'ruang_id' => $request->ruang_id,
            'tanggal_booking' => $request->tanggal_booking,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'nama' => $request->nama,
            'jumlah_orang' => $request->jumlah_orang,
            'keperluan' => $request->keperluan,
            'status' => 'active',
        ]);

        $booking->load('ruang');

        Notification::route('mail', 'mathildaanneke10@gmail.com')
            ->notify(new BookingCreated($booking));

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

        if ($booking->status !== 'active') {
            return back()->with('error', 'Booking tidak dapat dibatalkan karena sudah selesai atau dibatalkan.');
        }

        $booking->status = 'cancelled';
        $booking->save();

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil dibatalkan.');
    }


    public function jadwal($ruang_id)
    {
        $ruang = Ruang::findOrFail($ruang_id);
        $now = Carbon::now();

        $bookings = Booking::where('ruang_id', $ruang_id)
            ->where('status', 'active')
            ->whereColumn('jam_selesai', '>', 'jam_mulai') 
            ->where(function ($query) use ($now) {
                $query->where('tanggal_booking', '>', $now->toDateString())
                    ->orWhere(function ($q) use ($now) {
                        $q->where('tanggal_booking', $now->toDateString())
                            ->where('jam_selesai', '>=', $now->format('H:i:s'));
                    });
            })
            ->orderBy('tanggal_booking')
            ->orderBy('jam_mulai')
            ->get();

        return view('user.jadwal.ruang', compact('ruang', 'bookings'));
    }



    public function riwayat()
    {
       $bookings = Booking::where('user_id', auth()->id())
    ->orderBy('tanggal_booking', 'desc') // urutkan tanggal terbaru duluan
    ->orderBy('jam_mulai', 'desc')       // urutkan by jam
    ->get();

        return view('user.jadwal.riwayat', compact('bookings'));
    }
}
