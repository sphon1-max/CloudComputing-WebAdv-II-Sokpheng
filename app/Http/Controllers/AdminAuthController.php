<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (Auth::guard('admin')->attempt([
        'email' => $request->email,
        'password' => $request->password
    ])) {
        return redirect('/dashboard');
    }

    return back()->withErrors(['Invalid email or password.']);

    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
        
    }
}
