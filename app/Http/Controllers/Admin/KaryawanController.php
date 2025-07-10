<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawans = User::where('role', 'karyawan')->get();
        return view('admin.karyawan.index', compact('karyawans'));
    }

    public function create()
    {
        return view('admin.karyawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'email' => $request->email,
            'role' => 'karyawan',
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
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
            'nama' => 'required',
            'jabatan' => 'required',
            'email' => 'required|email|unique:users,email,' . $karyawan->id,
        ]);

        $karyawan->update([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.karyawan.index')->with('success', 'Data karyawan diperbarui.');
    }

    public function detail($id)
    {
        $karyawan = User::findOrFail($id);
        return view('admin.karyawan.detail', compact('karyawan'));
    }

    public function destroy($id)
    {
        $karyawan = User::findOrFail($id);
        $karyawan->delete();
        return redirect()->route('admin.karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}
