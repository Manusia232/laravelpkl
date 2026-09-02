<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        * {
            box-sizing: border-box;
        }

        /* body { */
            /* margin: 0; */
            /* font-family: Arial, sans-serif; */
            /* background: #c73131; */
            /* background-image: url("https://www.byd.com/material/byd-site/id/home/section-atto3-c.jpg"); */
            /* display: flex; */
            /* align-items: center; */
            /* justify-content: center; */
            /* min-height: 100vh; */
            /* padding: 20px; */
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


        .login-box {
            width: 100%;
            max-width: 400px;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .1);
        }

        .login-box .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-box .logo h2 {
            margin: 0;
            color: #1a1a2e;
            font-size: 24px;
        }

        .login-box .logo p {
            margin: 5px 0 0;
            color: #6b7280;
            font-size: 14px;
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

        .input-wrapper {
            position: relative;
        }

        input {
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
        }

        input.error {
            border-color: #dc2626;
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
            color: #9ca3af;
            transition: color 0.2s ease;
        }

        .toggle-password:hover {
            color: #2563eb;
        }

        /* .toggle-password svg {
            width: 20px;
            height: 20px;
        } */
        
        .toggle-password img {
            width: 20px;
            height: 20px;
            display: block;
        }
        button[type="submit"] {
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

        button[type="submit"]:hover {
            background: #1d4ed8;
        }

        button[type="submit"]:disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }

        .alert {
            padding: 10px 14px;
            border-radius: 7px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .alert-error {
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .form-options label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: normal;
            color: #6b7280;
            cursor: pointer;
        }

        .form-options input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .forgot-link {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 14px;
            color: #6b7280;
        }

        .register-link a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 480px) {
            .login-box {
                padding: 20px;
            }
            
            .form-options {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
<img class="bg-image" src="https://media.istockphoto.com/id/1002280786/id/foto/jalan-berliku-swiss.jpg" alt="">
<div class="login-box">
    <div class="logo">
        <h2>Login</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.submit') }}" id="loginForm">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                placeholder="contoh@gmail.com" 
                value="{{ old('email') }}"
                required 
                autocomplete="email"
                class="{{ $errors->has('email') ? 'error' : '' }}"
            >
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <div class="input-wrapper">
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="password-input"
                    placeholder="Masukkan password" 
                    required 
                    autocomplete="current-password"
                    class="{{ $errors->has('password') ? 'error' : '' }}"
                >
                <button type="button" class="toggle-password" onclick="togglePasswordVisibility('password')" aria-label="Tampilkan password">
                      <img src="https://img.icons8.com/?size=512w&id=13758&format=png" alt="Compare" class="compare-img" />
                </button>
            </div>
        </div>

        <div class="form-options">
            <label for="remember">
                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                Ingat saya
            </label>
            <a href="{{ route('password.reset') }}" class="forgot-link">Lupa Password?</a>
        </div>

        <button type="submit" id="loginButton">
            Login
        </button>
    </form>

    <div class="register-link">
        Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
    </div>
</div>

<script>
    function togglePasswordVisibility(fieldId) {
        const passwordInput = document.getElementById(fieldId);
        const toggleButton = passwordInput.parentElement.querySelector('.toggle-password');
        const isPasswordVisible = passwordInput.type === 'text';
        
        passwordInput.type = isPasswordVisible ? 'password' : 'text';
        
        if (isPasswordVisible) {
            toggleButton.innerHTML = `
                 <img src="https://img.icons8.com/?size=512w&id=13758&format=png" alt="Compare" class="compare-img" />
            `;
        } else {
            toggleButton.innerHTML = `
            <img src="https://img.icons8.com/?size=512w&id=121535&format=png" alt="Compare" class="compare-img" />
            `;
        }
    }

    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const button = document.getElementById('loginButton');
        const originalText = button.textContent;
        
        button.disabled = true;
        button.innerHTML = '<span style="display:inline-block;width:16px;height:16px;border:2px solid #ffffff;border-top:2px solid transparent;border-radius:50%;animation:spin 0.8s linear infinite;vertical-align:middle;margin-right:8px;"></span> Memproses...';
        
        setTimeout(function() {
            if (!document.querySelector('.alert-error')) {
                button.disabled = false;
                button.textContent = originalText;
            }
        }, 5000);
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            const form = document.getElementById('loginForm');
            if (document.activeElement === document.getElementById('email') || 
                document.activeElement === document.getElementById('password')) {
                form.dispatchEvent(new Event('submit'));
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const emailField = document.getElementById('email');
        if (emailField.value === '') {
            emailField.focus();
        } else {
            document.getElementById('password').focus();
        }
    });
</script>

</body>
</html>