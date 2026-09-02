<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke dashboard/profile
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Cek user dan password
        if (!$user) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput($request->only('email'));
        }

        // Cek password dengan fallback ke password_verify jika Hash::check gagal
        $passwordValid = false;
        
        try {
            // Coba dengan Hash::check (Bcrypt)
            $passwordValid = Hash::check($request->password, $user->password);
        } catch (\Exception $e) {
            // Jika gagal, coba dengan password_verify (untuk hash lama)
            $passwordValid = password_verify($request->password, $user->password);
        }

        if (!$passwordValid) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput($request->only('email'));
        }

        // Login user (tanpa remember token untuk menghindari error)
        Auth::login($user, false);

        // Regenerate session untuk keamanan
        $request->session()->regenerate();

        // Handle Remember Me dengan cookie (bukan database)
        if ($request->has('remember')) {
            // Simpan email ke cookie selama 30 hari
            Cookie::queue(
                'remember_email',
                $user->email,
                43200, // 30 hari (60 menit * 24 jam * 30 hari)
                '/',
                null,
                false,
                true,
                false,
                'lax'
            );
            
            // Simpan user_id ke cookie untuk auto-login
            Cookie::queue(
                'remember_id',
                $user->id,
                43200,
                '/',
                null,
                false,
                true,
                false,
                'lax'
            );
        } else {
            // Hapus cookie remember jika tidak dicentang
            Cookie::queue(Cookie::forget('remember_email'));
            Cookie::queue(Cookie::forget('remember_id'));
        }

        // Redirect berdasarkan role
        return $this->redirectBasedOnRole();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Hapus cookie remember
        Cookie::queue(Cookie::forget('remember_email'));
        Cookie::queue(Cookie::forget('remember_id'));

        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }

    protected function redirectBasedOnRole()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Redirect ke profile untuk user biasa
        return redirect()->route('profile.index');
    }
}