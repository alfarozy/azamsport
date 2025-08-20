<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    protected $redirectTo = '/dashboard';

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {

        if ($request->email && $request->password) {

            $user = User::whereEmail($request->email)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                if ($user->enabled == 1) {

                    Auth::guard()->login($user);

                    if ($user->role == 'admin') {

                        return redirect()->route('dashboard');
                    } else {
                        return redirect()->route('user.orders.index');
                    }
                } else {
                    return redirect()->route('login')->with('msg', '<b>Login gagal</b>,Akun belum aktif atau sementara dinonaktifkan oleh admin');
                }
            } else {
                return redirect()->route('login')->with('msg', '<b>Login gagal</b>,email atau password salah');
            }
        } else {
            return redirect()->route('login')->with('msg', 'Email dan password wajib');
        }
    }

    public function logout()
    {
        Auth()->logout();
        request()->session()->invalidate();
        request()->session()->flush();;
        request()->session()->regenerateToken();
        return redirect()->route('login');
    }
}
