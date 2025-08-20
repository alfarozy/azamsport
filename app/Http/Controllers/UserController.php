<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        if (auth()->user()->role != 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses');
        }
    }
    public function index()
    {

        $users = User::get();
        return view('backoffice.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('backoffice.users.show', compact('user'));
    }

    public function setActive($id)
    {
        $data = User::findOrFail($id);
        if ($data->enabled == 1) {
            $data->update(['enabled' => 0]);
            return redirect()->back()->with('success', $data->name . " has been nonactived");
        } else {
            $data->update(['enabled' => 1]);
            return redirect()->back()->with('success', $data->name . " has been nonactived");
        }
        return redirect()->route('users.index');
    }
}
