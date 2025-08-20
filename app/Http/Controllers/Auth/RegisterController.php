<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            // 2. Buat user baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user', // default role
                'enabled' => 1,   // otomatis aktif, kalau mau pending bisa set 0
            ]);

            // 3. Login otomatis setelah register
            Auth::login($user);

            // 4. Redirect ke dashboard
            return redirect()->route('homepage.products')
                ->with('success', 'Registrasi berhasil, selamat datang ' . $user->name . '!');
        } catch (\Exception $e) {
            return redirect()->route('register')
                ->with('msg', 'Terjadi kesalahan saat registrasi: ' . $e->getMessage());
        }
    }
}
