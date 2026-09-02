<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        * {
            box-sizing: border-box;
        }
        
        /* body { */
            /* margin: 0; */
            /* font-family: Arial, sans-serif; */
            /* background: #f2f4f7; */
            /* display: flex; */
            /* justify-content: center; */
            /* align-items: center; */
            /* min-height: 100vh; */
        /* } */

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .bg-image {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        
        .container {
            width: 100%;
            max-width: 400px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }
        
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #1a1a2e;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #333;
            font-size: 14px;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 7px;
            font-size: 15px;
            transition: border-color 0.15s ease;
        }
        
        input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.1);
        }
        
        .password-input {
            padding-right: 45px;
        }
        
        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            transition: color 0.2s ease;
        }
        
        .toggle-password:hover {
            color: #007bff;
        }
        
        .toggle-password img {
            width: 20px;
            height: 20px;
        }
        
        button[type="submit"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 7px;
            background: #007bff;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s ease;
        }
        
        button[type="submit"]:hover {
            background: #0056b3;
        }
        
        button[type="submit"]:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .hidden {
            display: none !important;
        }
        
        .message {
            margin-top: 15px;
            padding: 10px 14px;
            border-radius: 7px;
            display: none;
            font-size: 14px;
        }
        
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .info {
            text-align: center;
            color: #555;
            font-size: 14px;
            margin-bottom: 15px;
            line-height: 1.5;
        }
        
        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #6b7280;
        }
        
        .login-link a {
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
        }
        
        .login-link a:hover {
            text-decoration: underline;
        }

        .spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #ffffff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            vertical-align: middle;
            margin-right: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .password-match {
            border-color: #28a745 !important;
        }
        
        .password-mismatch {
            border-color: #dc3545 !important;
        }

        @media (max-width: 480px) {
            .container {
                padding: 20px;
                margin: 20px;
            }
        }
    </style>
</head>

<body>
<img class="bg-image" src="https://media.istockphoto.com/id/1002280786/id/foto/jalan-berliku-swiss.jpg" alt="">
    <div class="container">
        <div id="registerForm">
            <h2>Daftar Akun</h2>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" placeholder="Masukkan username" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Masukkan email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password" class="password-input" placeholder="Masukkan password" required minlength="6" oninput="checkPasswordMatch()">
                    <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password')" aria-label="Tampilkan password">
 <img src="https://img.icons8.com/?size=512w&id=13758&format=png" alt="Compare" class="compare-img" />
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <div class="input-wrapper">
                    <input type="password" id="password_confirmation" class="password-input" placeholder="Masukkan ulang password" required minlength="6" oninput="checkPasswordMatch()">
                    <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password_confirmation')" aria-label="Tampilkan password">
 <img src="https://img.icons8.com/?size=512w&id=13758&format=png" alt="Compare" class="compare-img" />
                    </button>
                </div>
                <small id="passwordMatchMessage" style="display: none; font-size: 12px;"></small>
            </div>

            <button type="submit" onclick="requestVerification()" id="registerBtn">
                Daftar
            </button>

            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Login</a>
            </div>
        </div>

        <div id="verificationForm" class="hidden">
            <h2>Verifikasi Email</h2>
            <p class="info">
                Kode verifikasi telah dikirim ke email Anda.<br>
                Silakan masukkan kode tersebut.
            </p>
            <div class="form-group">
                <label for="code">Kode Verifikasi</label>
                <input type="text" id="code" placeholder="Contoh: 580935" maxlength="6" required>
            </div>
            <button onclick="verifyCode()" id="verifyBtn">
                Verifikasi
            </button>
            <div class="login-link">
                <a href="#" onclick="resendCode()">Kirim ulang kode</a>
            </div>
        </div>
        <div id="message" class="message"></div>
    </div>

    <script>
        const API_URL = "{{ env('API_URL', 'https://43.106.115.184.nip.io/1150/api') }}";
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function togglePasswordVisibility(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleButton = passwordInput.parentElement.querySelector('.toggle-password');
            const isPasswordVisible = passwordInput.type === 'text';
            
            passwordInput.type = isPasswordVisible ? 'password' : 'text';
            
            toggleButton.innerHTML = isPasswordVisible ? `
            <img src="https://img.icons8.com/?size=512w&id=13758&format=png" alt="Compare" class="compare-img" />
            ` : `
             <img src="https://img.icons8.com/?size=512w&id=121535&format=png" alt="Compare" class="compare-img" />
            `;
        }

        function checkPasswordMatch() {
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('password_confirmation');
            const message = document.getElementById('passwordMatchMessage');
            
            if (confirmPassword.value.length === 0) {
                message.style.display = 'none';
                password.classList.remove('password-match', 'password-mismatch');
                confirmPassword.classList.remove('password-match', 'password-mismatch');
                return;
            }
            
            if (password.value === confirmPassword.value) {
                message.style.display = 'block';
                message.style.color = '#28a745';
                message.textContent = '✓ Password cocok';
                password.classList.remove('password-mismatch');
                password.classList.add('password-match');
                confirmPassword.classList.remove('password-mismatch');
                confirmPassword.classList.add('password-match');
            } else {
                message.style.display = 'block';
                message.style.color = '#dc3545';
                message.textContent = '✗ Password tidak cocok';
                password.classList.remove('password-match');
                password.classList.add('password-mismatch');
                confirmPassword.classList.remove('password-match');
                confirmPassword.classList.add('password-mismatch');
            }
        }

        async function requestVerification() {

            const username = document.getElementById("username").value.trim();
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("password_confirmation").value;
            const btn = document.getElementById("registerBtn");
            
            if (!username || !email || !password || !confirmPassword) {
                showMessage("Semua field harus diisi.", "error");
                return;
            }
            if (password.length < 6) {
                showMessage("Password minimal 6 karakter.", "error");
                return;
            }
            if (password !== confirmPassword) {
                showMessage("Password dan konfirmasi password tidak cocok.", "error");
                return;
            }
            
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner"></span> Memproses...';

            try {

                showMessage("Mengirim kode verifikasi...", "success");

                const response = await fetch("{{ route('request.verification') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": CSRF_TOKEN
                    },
                    body: JSON.stringify({
                        username: username,
                        email: email,
                        password: password
                    })
                });

                const result = await response.json();

                if (result.success) {
                    document.getElementById("registerForm").classList.add("hidden");
                    document.getElementById("verificationForm").classList.remove("hidden");
                    showMessage(
                        "Kode verifikasi telah dikirim ke email Anda.",
                        "success"
                    );

                    document.getElementById("code").focus();
                } else {
                    showMessage(
                        result.message || "Gagal mengirim kode.",
                        "error"
                    );
                }
            } catch (error) {
                console.error(error);
                showMessage(
                    "Tidak dapat terhubung ke server.",
                    "error"
                );
            } finally {
                btn.disabled = false;
                btn.innerHTML = 'Daftar';
            }
        }
        
        async function verifyCode() {

            const code = document.getElementById("code").value.trim();
            const btn = document.getElementById("verifyBtn");

            if (!code) {
                showMessage("Masukkan kode verifikasi.", "error");
                return;
            }

            if (code.length !== 6) {
                showMessage("Kode verifikasi harus 6 digit.", "error");
                return;
            }
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner"></span> Memverifikasi...';

            try {

                showMessage("Memverifikasi kode...", "success");

                const response = await fetch("{{ route('verify.code') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": CSRF_TOKEN
                    },
                    body: JSON.stringify({
                        code: code
                    })
                });

                const result = await response.json();

                if (result.success) {

                    showMessage(
                        "Verifikasi berhasil! Akun Anda telah terdaftar.",
                        "success"
                    );
                    setTimeout(() => {
                        window.location.href = "{{ route('login') }}";
                    }, 2000);

                } else {

                    showMessage(
                        result.message || "Kode verifikasi salah.",
                        "error"
                    );
                }

            } catch (error) {

                console.error(error);
                showMessage(
                    "Tidak dapat terhubung ke server.",
                    "error"
                );

            } finally {
                btn.disabled = false;
                btn.innerHTML = 'Verifikasi';
            }
        }
        
        async function resendCode() {
            const btn = document.querySelector('.login-link a');
            try {
                btn.textContent = 'Mengirim ulang...';
                btn.style.pointerEvents = 'none';
                const response = await fetch("{{ route('request.verification') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": CSRF_TOKEN
                    },
                    body: JSON.stringify({
                        resend: true
                    })
                });

                const result = await response.json();

                if (result.success) {
                    showMessage(
                        "Kode verifikasi baru telah dikirim ke email Anda.",
                        "success"
                    );
                } else {
                    showMessage(
                        result.message || "Gagal mengirim ulang kode.",
                        "error"
                    );
                }

            } catch (error) {
                console.error(error);
                showMessage(
                    "Tidak dapat terhubung ke server.",
                    "error"
                );
            } finally {
                btn.textContent = 'Kirim ulang kode';
                btn.style.pointerEvents = 'auto';
            }
        }
        
        function showMessage(text, type) {
            const message = document.getElementById("message");
            message.textContent = text;
            message.className = "message " + type;
            message.style.display = "block";
            if (type === 'success') {
                clearTimeout(window.messageTimeout);
                window.messageTimeout = setTimeout(() => {
                    message.style.display = "none";
                }, 5000);
            }
        }
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                const verificationForm = document.getElementById('verificationForm');
                if (!verificationForm.classList.contains('hidden')) {
                    verifyCode();
                }
            }
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('username').focus();
        });
    </script>

</body>

</html>