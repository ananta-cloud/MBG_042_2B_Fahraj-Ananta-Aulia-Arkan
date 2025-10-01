<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Controllers\GudangDashbordController;
use App\Http\Controllers\DapurDashboardController;

class AuthController
{
    /**
     * Menampilkan halaman form login.
     */
    public function login(): View
    {
        return view('auth.login');
    }

    /**
     * Memproses percobaan login dari pengguna.
     */
    public function loginUser(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
             if ($user->role === 'gudang') {
                return redirect()->action([GudangDashboardController::class, 'index']);
            } elseif ($user->role === 'dapur') {
                return redirect()->action([DapurDashboardController::class, 'index']);
            }
            return redirect('/login');
        }

        return back()->withErrors([
            'email' => 'email atau password yang diberikan tidak cocok.',
        ])->onlyInput('email');
    }

    /**
     * Memproses logout pengguna.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
