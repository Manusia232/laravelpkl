<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class ProfileController extends Controller
{
    // Hapus constructor dengan middleware, pindahkan ke route

    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function updateName(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'password' => 'required|string'
        ]);

        $user = Auth::user();

        // Verifikasi password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password salah.'
            ], 400);
        }

        // Update nama
        $user->name = $request->name;
        $user->save();

        // Update session
        session(['name' => $user->name]);

        return response()->json([
            'success' => true,
            'name' => $user->name
        ]);
    }

    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,webp|max:2048'
        ]);

        $file = $request->file('foto');

        try {
            // Upload ke API eksternal
            $response = Http::attach(
                'foto', file_get_contents($file), $file->getClientOriginalName()
            )->post('https://43.106.115.184.nip.io/9/upload');

            $result = $response->json();

            if ($response->successful() && isset($result['success']) && $result['success']) {
                $fotoUrl = $result['foto'];

                // Update database
                $user = Auth::user();
                $user->url_photo = $fotoUrl;
                $user->save();

                // Update session
                session(['url_photo' => $fotoUrl]);

                return response()->json([
                    'success' => true,
                    'url_photo' => $fotoUrl
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Upload gagal diproses oleh server foto.'
                ], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghubungi server upload: ' . $e->getMessage()
            ], 500);
        }
    }

    public function requestResetCode(Request $request)
    {
        $user = Auth::user();

        try {
            $response = Http::post('https://43.106.115.184.nip.io/1151/api/request-reset-password', [
                'email' => $user->email
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['success']) && $result['success']) {
                // Simpan email di session untuk verifikasi
                session(['reset_email' => $user->email]);

                return response()->json([
                    'success' => true,
                    'message' => $result['message'] ?? 'Kode reset telah dikirim.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Gagal mengirim kode.'
                ], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat terhubung ke server.'
            ], 500);
        }
    }

    public function verifyResetCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:6'
        ]);

        $email = session('reset_email');

        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Silakan mulai ulang.'
            ], 400);
        }

        try {
            $response = Http::post('https://43.106.115.184.nip.io/1151/api/verify-reset-code', [
                'email' => $email,
                'code' => $request->code
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['success']) && $result['success']) {
                // Simpan kode di session untuk proses reset
                session(['reset_code' => $request->code]);

                return response()->json([
                    'success' => true,
                    'message' => $result['message'] ?? 'Kode verifikasi valid.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Kode verifikasi tidak valid.'
                ], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat terhubung ke server.'
            ], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'newPassword' => 'required|string|min:6',
            'confirmPassword' => 'required|string|min:6'
        ]);

        if ($request->newPassword !== $request->confirmPassword) {
            return response()->json([
                'success' => false,
                'message' => 'Konfirmasi password tidak cocok.'
            ], 400);
        }

        $email = session('reset_email');
        $code = session('reset_code');

        if (!$email || !$code) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Silakan mulai ulang.'
            ], 400);
        }

        try {
            $response = Http::post('https://43.106.115.184.nip.io/1151/api/reset-password', [
                'email' => $email,
                'code' => $code,
                'newPassword' => $request->newPassword
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['success']) && $result['success']) {
                // Hapus session
                session()->forget(['reset_email', 'reset_code']);

                // Logout user
                Auth::logout();
                session()->invalidate();
                session()->regenerateToken();

                return response()->json([
                    'success' => true,
                    'message' => $result['message'] ?? 'Password berhasil diubah.',
                    'redirect' => route('login')
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Gagal mengubah password.'
                ], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat terhubung ke server.'
            ], 500);
        }
    }
}