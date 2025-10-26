<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::guard('admin')->user();
        return view('admin.profile.index', compact('user'));
    }

    public function editPassword()
    {
        return view('admin.profile.edit-password');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Password lama salah.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah.');
    }
    public function settings()
    {
        $user = Auth::user();
        return view('admin.profile.settings', compact('user'));
    }

}

//     public function editPassword()
//     {
//         return view('admin.profile.edit-password');
//     }

//     public function updatePassword(Request $request)
//     {
//         $request->validate([
//             'old_password' => 'required',
//             'new_password' => 'required|min:6|confirmed',
//         ]);

//         $user = auth()->user();

//         if (!Hash::check($request->old_password, $user->password)) {
//             return back()->withErrors(['old_password' => 'Password lama salah.']);
//         }

//         $user->password = Hash::make($request->new_password);
//         $user->save();

//         return back()->with('success', 'Password berhasil diubah.');
//     }
// }
