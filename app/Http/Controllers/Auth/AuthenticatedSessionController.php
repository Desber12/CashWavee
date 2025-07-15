<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Tangani proses login.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Lakukan autentikasi user
        $request->authenticate();

        // Regenerasi session untuk keamanan
        $request->session()->regenerate();

        // ✅ Cek role: hanya admin yang boleh login
        if (auth()->user()->role !== 'admin') {
            // Logout user yang bukan admin
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Kembali ke halaman login dengan pesan error
            return redirect('/login')->withErrors([
                'email' => 'Hanya admin yang dapat login.',
            ]);
        }

        // ✅ Jika role admin, arahkan ke dashboard
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Logout dari sesi login.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
