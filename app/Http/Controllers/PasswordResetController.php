<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class PasswordResetController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('API_URL', 'https://43.106.115.184.nip.io/1151/api');
    }

    public function showResetForm()
    {
        return view('auth.reset-password');
    }

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        try {
            $response = Http::post($this->apiUrl . '/check-email-exists', [
                'email' => $request->email
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['success']) && $result['success']) {
                session(['reset_email' => $request->email]);
                
                return response()->json([
                    'success' => true,
                    'message' => $result['message'] ?? 'Email terdaftar.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Email tidak terdaftar.'
                ], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat terhubung ke server.'
            ], 500);
        }
    }

    public function requestReset(Request $request)
    {
        $email = session('reset_email');

        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Silakan mulai ulang.'
            ], 400);
        }

        try {
            $response = Http::post($this->apiUrl . '/request-reset-password', [
                'email' => $email
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['success']) && $result['success']) {
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

    public function verifyCode(Request $request)
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
            $response = Http::post($this->apiUrl . '/verify-reset-code', [
                'email' => $email,
                'code' => $request->code
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['success']) && $result['success']) {
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
            $response = Http::post($this->apiUrl . '/reset-password', [
                'email' => $email,
                'code' => $code,
                'newPassword' => $request->newPassword
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['success']) && $result['success']) {
                session()->forget(['reset_email', 'reset_code']);
                
                return response()->json([
                    'success' => true,
                    'message' => $result['message'] ?? 'Password berhasil direset.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Gagal melakukan reset password.'
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