<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() 
    { 
        return view('auth.login'); 
    }

    public function showRegister() 
    { 
        return view('auth.register'); 
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100', 
            'email' => 'required|email|unique:users,email', 
            'phone' => 'nullable|string|max:30', 
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = User::create([
            ...$data, 
            'password' => Hash::make($data['password']), 
            'role' => 'customer'
        ]);

        $this->startSession($user);

        return redirect()->route('dashboard')->with('success', 'Akun berhasil dibuat. Selamat datang!');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email', 
            'password' => 'required|string'
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'Email atau password belum sesuai.'
            ])->onlyInput('email');
        }

        $this->startSession($user);

        return redirect()->route('dashboard')->with('success', 'Berhasil masuk.');
    }

    private function startSession(User $user): void
    {
        session([
            'user_id' => $user->id, 
            'user_name' => $user->name, 
            'user_role' => $user->role
        ]);
        
        request()->session()->regenerate();
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate(); 
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Kamu sudah keluar dari akun.');
    }
}