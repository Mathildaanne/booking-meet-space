<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruang;
use Illuminate\Support\Facades\Storage;

class RuangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ruang = Ruang::all(); return view('admin.ruang.index', compact('ruang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.ruang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) { 
        $request->validate([ 
            'nama' => 'required|string|max:100', 
            'kapasitas' => 'required|integer|min:1', 
            'jam_buka' => 'required|date_format:H:i', 
            'jam_tutup' => 'required|date_format:H:i|after:jam_buka', 
            'fasilitas' => 'nullable|string', 
            'lantai' => 'nullable|integer', 
            //'foto' => 'nullable|image|max:2048' 
        ]); 
            
        $data = $request->all(); 
        if ($request->hasFile('foto')) { 
            $data['foto'] = $request->file('foto')->store('ruang', 'public'); 
        } 
        
        Ruang::create($data); 
        return redirect()->route('admin.ruang.index')->with('success', 'Ruang berhasil ditambahkan.'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Ruang $ruang) { 
        return view('admin.ruang.show', ['ruang' => $ruang]); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ruang $ruang) { 
        return view('admin.ruang.edit', ['ruang' => $ruang]); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ruang $ruang) {
 
        $request->validate([ 
            'nama' => 'required|string|max:100', 
            'kapasitas' => 'required|integer|min:1', 
            'jam_buka' => 'required|date_format:H:i', 
            'jam_tutup' => 'required|date_format:H:i|after:jam_buka', 
            'fasilitas' => 'nullable|string', 
            'lantai' => 'nullable|integer', 
            'foto' => 'nullable|image|max:2048' 
        ]); 
        
        $data = $request->only(['nama', 'kapasitas', 'jam_buka', 'jam_tutup', 'fasilitas', 'lantai']);

        if ($request->hasFile('foto')) {
            if ($ruang->foto) {
                \Storage::disk('public')->delete($ruang->foto);
            }
            $data['foto'] = $request->file('foto')->store('ruang', 'public');
        }
        $ruang->update($data);
 
        return redirect()->route('admin.ruang.index')->with('success', 'Ruang berhasil diperbarui.'); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ruang $ruang) { 
        $ruang->delete(); 
        return redirect()->route('admin.ruang.index')->with('success', 'Ruang berhasil dihapus.');
    }
}