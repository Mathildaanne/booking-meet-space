<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $query = User::query();

    // filter berdasarkan status (active/inactive)
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // filter berdasarkan keyword pencarian
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%');
        });
    }

    $karyawans = $query->paginate(10);

    return view('admin.karyawan.index', compact('karyawans'));
}


    public function create()
    {
        return view('admin.karyawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'jabatan'  => 'required|string|max:50',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fotoName = null;
        if ($request->hasFile('foto')) {
            $fotoName = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->storeAs('public/foto', $fotoName);
        }

        User::create([
            'nama'     => $request->nama,
            'jabatan'  => $request->jabatan,
            'email'    => $request->email,
            'role'     => 'karyawan',
            'status'   => $request->status ?? 'active',  
            'foto'     => $fotoName,
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $karyawan = User::findOrFail($id);
        return view('admin.karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, $id)
    {
        $karyawan = User::findOrFail($id);

        $request->validate([
            'nama'     => 'required|string|max:100',
            'jabatan'  => 'required|string|max:50',
            'email'    => 'required|email|unique:users,email,' . $karyawan->id,
            'password' => 'nullable|min:6',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'   => 'required|in:active,inactive',
        ]);

        if ($request->hasFile('foto')) {
            if ($karyawan->foto && Storage::exists('public/foto/' . $karyawan->foto)) {
                Storage::delete('public/foto/' . $karyawan->foto);
            }
            $newFoto = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->storeAs('public/foto', $newFoto);
            $karyawan->foto = $newFoto;
        }

        $karyawan->nama    = $request->nama;
        $karyawan->jabatan = $request->jabatan;
        $karyawan->email   = $request->email;
        $karyawan->status  = $request->status;

        if ($request->filled('password')) {
            $karyawan->password = Hash::make($request->password);
        }

        $karyawan->save();

        return redirect()
            ->route('admin.karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function detail($id)
    {
        $karyawan = User::findOrFail($id);
        return view('admin.karyawan.show', compact('karyawan'));
    }

    public function destroy($id)
    {
        $karyawan = User::findOrFail($id);
        $karyawan->delete();
        return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}