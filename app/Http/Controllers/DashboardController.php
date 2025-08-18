<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{

    public function index()
    {
        $data = [
            'project' => 2,
            'article' => 4,
            'technology' => 5,
            'project_popular' => 6,
            'article_popular' => 8,
        ];
        return view('backoffice.index', $data);
    }

    public function profile()
    {
        $user =  Auth()->user();
        return view('backoffice.profile.index', compact('user'));
    }
    public function changePassword()
    {
        return view('backoffice.profile.update-password');
    }

    public function updatePassword(Request $request)
    {
        $attr  = $request->validate([
            'password' => 'required:min:3|confirmed',
            'old_password' => 'required:min:3',
        ], [
            '*.required'    => 'Bidang ini wajib'
        ]);

        $user = Auth()->user();
        if (Hash::check($attr['old_password'], $user->password)) {
            User::where('id', $user->id)->update(['password' => bcrypt($attr['password'])]);
            return redirect()->back()->with('msg', 'Passwrd berhasil diupdate');
        } else {
            return redirect()->back()->with('error', 'Passwrd lama anda salah,silahkan coba lagi');
        }
    }
    public function updateProfile(Request $request)
    {
        $attr  = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
        ]);

        $user = User::findOrFail(Auth()->id());

        $user->update($attr);
        return redirect()->back()->with('msg', 'Profile updated');
    }
}
