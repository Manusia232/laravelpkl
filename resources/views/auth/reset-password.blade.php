<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .reset-box {
            width: 100%;
            max-width: 420px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .1);
        }

        h2 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 10px;
            color: #1a1a2e;
        }

        .description {
            text-align: center;
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 500;
            color: #374151;
            font-size: 14px;
        }

        /* input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 7px;
            font-size: 15px;
            outline: none;
            transition: border-color 0.15s ease;
        }

        input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
        } */

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 7px;
            font-size: 15px;
            transition: border-color 0.15s ease;
        }
/*
        input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.1);
        } */

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

        /* .toggle-password:hover {
            color: #007bff;
        } */

        .toggle-password svg {
            width: 20px;
            height: 20px;
        }

        .password-wrapper {
    position: relative;
    width: 100%;
}

.password-wrapper input {
    width: 100%;
    padding: 12px 60px 12px 12px;
    border: 1px solid #ccc;
    border-radius: 7px;
    font-size: 15px;
    transition: border-color 0.15s ease;
}

/* .password-wrapper input:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.1);
} */

.toggle-password {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);

    width: 36px;
    height: 36px;

    padding: 0;
    margin: 0;

    border: none;
    background: transparent;

    display: flex;
    align-items: center;
    justify-content: center;

    cursor: pointer;
    color: #666;

    z-index: 2;
}

/* .toggle-password:hover {
    color: #007bff;
} */

.toggle-password svg {
    width: 20px;
    height: 20px;
    display: block;
    pointer-events: none;
}


        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 7px;
            background: #2563eb;
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        button:hover:not(:disabled) {
            background: #1d4ed8;
        }

        button:disabled {
            background: #9ca3af;
            cursor: not-allowed;
            opacity: 0.7;
        }

        button .spinner {
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

        .message {
            padding: 10px 14px;
            border-radius: 7px;
            margin-bottom: 15px;
            font-size: 14px;
            display: none;
        }

        .message.success {
            display: block;
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .message.error {
            display: block;
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        .email-info {
            background: #eff6ff;
            color: #1d4ed8;
            padding: 10px 14px;
            border-radius: 7px;
            margin-bottom: 15px;
            font-size: 14px;
            word-break: break-word;
            border: 1px solid #bfdbfe;
        }

        .back-button {
            margin-top: 10px;
            background: #e5e7eb;
            color: #374151;
        }

        .back-button:hover:not(:disabled) {
            background: #d1d5db;
        }

        .password-info {
            font-size: 12px;
            color: #6b7280;
            margin-top: 5px;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #6b7280;
        }

        .login-link a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .success-icon {
            font-size: 50px;
            margin-bottom: 10px;
            display: block;
        }

        .success-box {
            text-align: center;
            padding: 15px 0;
        }

        .success-box h3 {
            margin-bottom: 10px;
            color: #1a1a2e;
        }

        .success-box p {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.6;
        }

        .success-box .login-btn {
            display: block;
            margin-top: 20px;
            padding: 12px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 7px;
            font-weight: 600;
            transition: background 0.15s ease;
        }

        .success-box .login-btn:hover {
            background: #1d4ed8;
        }

        @media (max-width: 480px) {
            .reset-box {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="reset-box">

        <h2>Reset Password</h2>

        <div class="description">
            Masukkan email Anda untuk mengatur ulang password.
        </div>

        <div id="message" class="message"></div>

        <div id="stepEmail" class="step active">

            <form id="emailForm">

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="contoh@gmail.com" required autocomplete="email">
                </div>

                <button type="submit" id="emailButton">
                    Lanjutkan
                </button>

                <div class="login-link">
                    <a href="{{ route('login') }}">← Kembali ke Login</a>
                </div>

            </form>

        </div>

        <div id="stepSendCode" class="step">

            <div class="email-info">
                Email terdaftar:
                <strong id="emailDisplay"></strong>
            </div>

            <p style="font-size:14px;color:#555;margin-bottom:15px;">
                Kami akan mengirimkan kode reset password ke email tersebut.
            </p>

            <button type="button" id="sendCodeButton">
                Kirim Kode Reset
            </button>

            <button type="button" class="back-button" onclick="showStep('stepEmail')">
                Kembali
            </button>

        </div>

        <div id="stepCode" class="step">

            <div class="email-info">
                Kode dikirim ke:
                <strong id="emailDisplayCode"></strong>
            </div>

            <form id="codeForm">

                <div class="form-group">
                    <label for="code">Kode Verifikasi</label>
                    <input type="text" id="code" placeholder="Masukkan 6 digit kode" maxlength="6" inputmode="numeric" autocomplete="one-time-code" required>
                </div>

                <button type="submit" id="codeButton">
                    Verifikasi Kode
                </button>

                <button type="button" class="back-button" onclick="resendCode()" id="resendButton">
                    Kirim Ulang Kode
                </button>

            </form>

        </div>

        <div id="stepPassword" class="step">

            <div class="email-info">
                Reset password untuk:
                <strong id="emailDisplayPassword"></strong>
            </div>

            <form id="passwordForm">

                <div class="form-group">
                    <label for="newPassword">Password Baru</label>
                    <div class="password-wrapper">
                        <input type="password" id="newPassword" placeholder="Masukkan password baru" required autocomplete="new-password" minlength="6">
                        <button type="button" class="toggle-password" onclick="togglePasswordVisibility('newPassword')" aria-label="Tampilkan password">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    <div class="password-info">
                        Gunakan password yang mudah Anda ingat (minimal 6 karakter).
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirmPassword">Konfirmasi Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="confirmPassword" placeholder="Ulangi password baru" required autocomplete="new-password" minlength="6">
                        <button type="button" class="toggle-password" onclick="togglePasswordVisibility('confirmPassword')" aria-label="Tampilkan password">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" id="passwordButton">
                    Reset Password
                </button>

            </form>

        </div>

        <div id="stepSuccess" class="step">

            <div class="success-box">
                <span class="success-icon">✅</span>
                <h3>Password Berhasil Direset</h3>
                <p>
                    Password Anda sudah berhasil diubah.
                    Silakan login menggunakan password baru.
                </p>
                <a href="{{ route('login') }}" class="login-btn">
                    Kembali ke Login
                </a>
            </div>

        </div>

    </div>

    <script>
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let userEmail = '';
        let resetCode = '';

        function togglePasswordVisibility(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleButton = passwordInput.parentElement.querySelector('.toggle-password');
            const isPasswordVisible = passwordInput.type === 'text';

            passwordInput.type = isPasswordVisible ? 'password' : 'text';

            toggleButton.innerHTML = isPasswordVisible ? `
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
            ` : `
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                    <line x1="1" y1="1" x2="23" y2="23"></line>
                </svg>
            `;
        }

        function showStep(stepId) {
            document.querySelectorAll('.step').forEach(function(step) {
                step.classList.remove('active');
            });

            document.getElementById(stepId).classList.add('active');
            clearMessage();
        }

        function showMessage(message, type = 'error') {
            const box = document.getElementById('message');
            box.textContent = message;
            box.className = 'message ' + type;

            if (type === 'success') {
                clearTimeout(window.messageTimeout);
                window.messageTimeout = setTimeout(() => {
                    box.style.display = 'none';
                }, 5000);
            }
        }

        function clearMessage() {
            const box = document.getElementById('message');
            box.textContent = '';
            box.className = 'message';
        }

        document.getElementById('emailForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const email = document.getElementById('email').value.trim();
            const button = document.getElementById('emailButton');

            if (!email) {
                showMessage('Email wajib diisi.');
                return;
            }

            button.disabled = true;
            button.innerHTML = '<span class="spinner"></span> Memeriksa...';

            try {
                const response = await fetch("{{ route('password.check') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify({ email: email })
                });

                const result = await response.json();

                if (result.success) {
                    userEmail = email;
                    document.getElementById('emailDisplay').textContent = email;

                    showMessage(result.message || 'Email terdaftar.', 'success');
                    showStep('stepSendCode');
                } else {
                    showMessage(result.message || 'Email tidak terdaftar.');
                }

            } catch (error) {
                console.error(error);
                showMessage('Tidak dapat terhubung ke server.');
            } finally {
                button.disabled = false;
                button.textContent = 'Lanjutkan';
            }
        });

        document.getElementById('sendCodeButton').addEventListener('click', async function() {
            const button = document.getElementById('sendCodeButton');

            button.disabled = true;
            button.innerHTML = '<span class="spinner"></span> Mengirim...';

            try {
                const response = await fetch("{{ route('password.request') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                });

                const result = await response.json();

                if (result.success) {
                    document.getElementById('emailDisplayCode').textContent = userEmail;

                    showMessage(result.message || 'Kode reset telah dikirim.', 'success');
                    showStep('stepCode');

                    document.getElementById('code').focus();
                } else {
                    showMessage(result.message || 'Gagal mengirim kode.');
                }

            } catch (error) {
                console.error(error);
                showMessage('Tidak dapat terhubung ke server.');
            } finally {
                button.disabled = false;
                button.textContent = 'Kirim Kode Reset';
            }
        });

        document.getElementById('codeForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const code = document.getElementById('code').value.trim();
            const button = document.getElementById('codeButton');

            if (!code) {
                showMessage('Kode verifikasi wajib diisi.');
                return;
            }

            if (code.length !== 6) {
                showMessage('Kode verifikasi harus 6 digit.');
                return;
            }

            button.disabled = true;
            button.innerHTML = '<span class="spinner"></span> Memverifikasi...';

            try {
                const response = await fetch("{{ route('password.verify') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify({ code: code })
                });

                const result = await response.json();

                if (result.success) {
                    resetCode = code;
                    document.getElementById('emailDisplayPassword').textContent = userEmail;

                    showMessage(result.message || 'Kode verifikasi valid.', 'success');
                    showStep('stepPassword');

                    document.getElementById('newPassword').focus();
                } else {
                    showMessage(result.message || 'Kode verifikasi tidak valid.');
                }

            } catch (error) {
                console.error(error);
                showMessage('Tidak dapat terhubung ke server.');
            } finally {
                button.disabled = false;
                button.textContent = 'Verifikasi Kode';
            }
        });

        async function resendCode() {
            const button = document.getElementById('resendButton');

            button.disabled = true;
            button.textContent = 'Mengirim ulang...';

            try {
                const response = await fetch("{{ route('password.request') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                });

                const result = await response.json();

                if (result.success) {
                    showMessage('Kode baru telah dikirim ke email Anda.', 'success');
                } else {
                    showMessage(result.message || 'Gagal mengirim ulang kode.');
                }

            } catch (error) {
                console.error(error);
                showMessage('Tidak dapat terhubung ke server.');
            } finally {
                button.disabled = false;
                button.textContent = 'Kirim Ulang Kode';
            }
        }

        document.getElementById('passwordForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const button = document.getElementById('passwordButton');

            if (!newPassword || !confirmPassword) {
                showMessage('Semua field harus diisi.');
                return;
            }

            if (newPassword.length < 6) {
                showMessage('Password minimal 6 karakter.');
                return;
            }

            if (newPassword !== confirmPassword) {
                showMessage('Konfirmasi password tidak cocok.');
                return;
            }

            button.disabled = true;
            button.innerHTML = '<span class="spinner"></span> Memproses...';

            try {
                const response = await fetch("{{ route('password.update') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify({
                        newPassword: newPassword,
                        confirmPassword: confirmPassword
                    })
                });

                const result = await response.json();

                if (result.success) {
                    showStep('stepSuccess');
                    showMessage(result.message || 'Password berhasil direset.', 'success');
                } else {
                    showMessage(result.message || 'Gagal melakukan reset password.');
                }

            } catch (error) {
                console.error(error);
                showMessage('Tidak dapat terhubung ke server.');
            } finally {
                button.disabled = false;
                button.textContent = 'Reset Password';
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                const activeStep = document.querySelector('.step.active');
                if (activeStep) {
                    const form = activeStep.querySelector('form');
                    if (form) {
                        form.dispatchEvent(new Event('submit'));
                    }
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('email').focus();
        });

        document.getElementById('code').addEventListener('input', function() {
            if (this.value.length === 6) {
                document.getElementById('codeForm').dispatchEvent(new Event('submit'));
            }
        });
    </script>

</body>

</html>
