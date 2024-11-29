<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //tampilan form registrasi
    public function register(Request $request)
    {
        return view('Auth.register');
    }

    //mengirimkan data registrasi
    public function registered(Request $request)
    {
        $request->validate([
            'name'              => 'required',
            'email'             => 'required',
            'password'          => 'required'
        ]);
        $dataStore = [
            'name'              => $request->name,
            'email'             => $request->email,
            'password'          => Hash::make($request->password)

        ];
        User::create($dataStore);
        return redirect('/');
    }

    public function login(Request $request)
    {
        return view('Auth.login');
    }

    // Proses login
    public function ceklogin(Request $request)
    {
        // Validasi input login
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Cek kredensial
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Regenerasi session untuk keamanan
            $request->session()->regenerate();

            return redirect('/dashboard')->with('success', 'Login berhasil!');
        } else {
            // Redirect kembali ke login dengan pesan error
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ]);
        }
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerate();
        return redirect('/');
    }
}
