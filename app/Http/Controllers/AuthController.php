<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('API_URL', 'https://43.106.115.184.nip.io/1150/api');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function requestVerification(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'password' => 'required|string|min:6'
        ]);

        try {
            $response = Http::post($this->apiUrl . '/request-verification', [
                'username' => $request->username,
                'email' => $request->email,
                'password' => $request->password
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['success']) && $result['success']) {
                // Simpan email di session untuk verifikasi
                session(['registered_email' => $request->email]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Kode verifikasi telah dikirim ke email Anda.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Gagal mengirim kode verifikasi.'
                ], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat terhubung ke server API.'
            ], 500);
        }
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:6'
        ]);

        $email = session('registered_email');

        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Silakan daftar ulang.'
            ], 400);
        }

        try {
            $response = Http::post($this->apiUrl . '/verify-code', [
                'email' => $email,
                'code' => $request->code
            ]);

            $result = $response->json();

            if ($response->successful() && isset($result['success']) && $result['success']) {
                // Hapus session setelah berhasil
                session()->forget('registered_email');
                
                return response()->json([
                    'success' => true,
                    'message' => 'Verifikasi berhasil! Akun Anda telah terdaftar.'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Kode verifikasi salah.'
                ], 400);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat terhubung ke server API.'
            ], 500);
        }
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
}