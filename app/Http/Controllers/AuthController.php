<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('kasir.pos');
            }
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // Simple role-based login for demo
    public function quickLogin($role)
    {
        // For demo purposes, create users if they don't exist
        $user = User::where('role', $role)->first();
        
        if (!$user) {
            $user = User::create([
                'username' => $role,
                'password' => bcrypt('password'),
                'nama' => ucfirst($role),
                'email' => $role . '@pos.com',
                'role' => $role,
            ]);
        }

        Auth::login($user);
        
        if ($role == 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('kasir.pos');
        }
    }
}