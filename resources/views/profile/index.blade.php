<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #ffffff;
            color: #1a1a1a;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Main Content - Flex agar footer di bawah */
        .main-content {
            flex: 1;
            padding: 32px 48px 60px;
            max-width: 1280px;
            margin: 0 auto;
            width: 100%;
        }

        .profile-wrap {
            max-width: 620px;
            margin: 0 auto;
            text-align: center;
        }

        /* Back Link */
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
        }

        .back-link:hover {
            color: #2563eb;
        }

        /* Avatar */
        .avatar-wrap {
            position: relative;
            width: 92px;
            height: 92px;
            margin: 0 auto 16px;
            cursor: pointer;
        }

        .avatar-ring {
            width: 92px;
            height: 92px;
            border-radius: 50%;
            padding: 3px;
            background: conic-gradient(from 0deg, #22c55e, #86efac, #22c55e);
        }

        .avatar-photo {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: #f4f4f5;
            background-image:
                linear-gradient(45deg, #eaeaea 25%, transparent 25%),
                linear-gradient(-45deg, #eaeaea 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #eaeaea 75%),
                linear-gradient(-45deg, transparent 75%, #eaeaea 75%);
            background-size: 14px 14px;
            background-position: 0 0, 0 7px, 7px -7px, -7px 0px;
            border: 3px solid #ffffff;
            overflow: hidden;
        }

        .avatar-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-edit-badge {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 22px;
            height: 22px;
            background-color: #22c55e;
            border: 2.5px solid #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-edit-badge svg {
            width: 11px;
            height: 11px;
        }

        /* Profile Info */
        .profile-name {
            font-size: 19px;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 3px;
        }

        .profile-username {
            font-size: 12.5px;
            color: #9a9a9a;
            margin-bottom: 34px;
        }

        /* Settings List */
        .settings-list {
            text-align: left;
            border-top: 1px solid #f0f0f0;
        }

        .settings-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px 4px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
        }

        .settings-row:hover {
            background-color: #fafafa;
        }

        .settings-row.disabled {
            cursor: default;
        }

        .settings-row.disabled:hover {
            background-color: transparent;
        }

        .row-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #e9fbef;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .row-icon svg {
            width: 15px;
            height: 15px;
            stroke: #22c55e;
        }

        .row-label {
            font-size: 13px;
            font-weight: 700;
            color: #1a1a1a;
            width: 90px;
            flex-shrink: 0;
        }

        .row-value {
            font-size: 13px;
            color: #6b6b6b;
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .row-chevron {
            font-size: 15px;
            color: #c7c7c7;
            flex-shrink: 0;
        }

        .row-note {
            font-size: 11px;
            color: #c7c7c7;
        }

        /* Logout Button */
        .logout-btn {
            margin-top: 32px;
            width: 100%;
            background-color: #fef2f2;
            color: #ef4444;
            border: none;
            border-radius: 10px;
            padding: 13px 0;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .logout-btn:hover {
            background-color: #fee2e2;
        }

        /* Modal */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            align-items: center;
            justify-content: center;
            padding: 20px;
            z-index: 100;
        }

        .modal-overlay.open {
            display: flex;
        }

        .modal-box {
            background: #fff;
            border-radius: 14px;
            padding: 24px;
            width: 100%;
            max-width: 360px;
            text-align: left;
        }

        .modal-title {
            font-size: 16px;
            font-weight: 800;
            margin-bottom: 16px;
        }

        .modal-box input[type="text"],
        .modal-box input[type="password"],
        .modal-box input[type="email"] {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            font-size: 13.5px;
            margin-bottom: 12px;
            outline: none;
        }

        .modal-box input:focus {
            border-color: #22c55e;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            margin-top: 6px;
        }

        .btn-primary {
            flex: 1;
            background-color: #22c55e;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 11px 0;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .btn-primary:hover:not(:disabled) {
            background-color: #16a34a;
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-secondary {
            flex: 1;
            background-color: #f5f6f8;
            color: #1a1a1a;
            border: none;
            border-radius: 8px;
            padding: 11px 0;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .btn-secondary:hover {
            background-color: #e5e7eb;
        }

        .modal-message {
            font-size: 12.5px;
            margin-bottom: 12px;
            padding: 8px 10px;
            border-radius: 8px;
            display: none;
        }

        .modal-message.error {
            display: block;
            background: #fef2f2;
            color: #ef4444;
        }

        .modal-message.success {
            display: block;
            background: #f0fdf4;
            color: #16a34a;
        }

        .modal-step {
            display: none;
        }

        .modal-step.active {
            display: block;
        }

        .modal-hint {
            font-size: 12px;
            color: #9a9a9a;
            margin-bottom: 12px;
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
            to {
                transform: rotate(360deg);
            }
        }

        /* Footer Styles */
        footer {
            margin-top: auto;
            background-color: #f8f9fa;
            padding: 20px 0;
            border-top: 1px solid #e9ecef;
        }

        .footer-content {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 48px;
        }

        /* Responsive */
        @media (max-width: 560px) {
            .main-content {
                padding: 24px;
            }

            .row-label {
                width: 70px;
            }

            .footer-content {
                padding: 0 24px;
            }
        }

        @media (max-width: 400px) {
            .modal-box {
                padding: 20px;
            }

            .modal-actions {
                flex-direction: column;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    @include('components.navbar')

    <div class="main-content">
        <div class="profile-wrap">

            <a href="{{ route('brands.index') }}" class="back-link">← Kembali ke Beranda</a>

            <div class="avatar-wrap" id="avatarWrap" title="Ubah foto profil">
                <div class="avatar-ring">
                    <div class="avatar-photo" id="avatarPhoto">
                        @if(!empty($user->url_photo))
                            <img src="{{ $user->url_photo }}" alt="Foto profil" id="avatarImg">
                        @endif
                    </div>
                </div>
                <div class="avatar-edit-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h9"></path>
                        <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                    </svg>
                </div>
                <input type="file" id="photoInput" accept="image/png, image/jpeg, image/webp" style="display:none;">
            </div>

            <div class="profile-name" id="displayName">{{ e($user->name) }}</div>
            <div class="profile-username">{{ e($user->username) }}</div>

            <div class="settings-list">
                <!-- Name (bisa diubah, minta password) -->
                <div class="settings-row" onclick="openModal('nameModal')">
                    <span class="row-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </span>
                    <span class="row-label">Name</span>
                    <span class="row-value" id="rowNameValue">{{ e($user->name) }}</span>
                    <span class="row-chevron">›</span>
                </div>

                <!-- Username (tidak bisa diubah) -->
                <div class="settings-row disabled">
                    <span class="row-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        </svg>
                    </span>
                    <span class="row-label">Username</span>
                    <span class="row-value">{{ e($user->username) }}</span>
                    <span class="row-note">Tidak dapat diubah</span>
                </div>

                <!-- Password (buka alur ubah password) -->
                <div class="settings-row" onclick="openModal('passwordModal')">
                    <span class="row-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </span>
                    <span class="row-label">Password</span>
                    <span class="row-value">•••••••••••••</span>
                    <span class="row-chevron">›</span>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>

        </div>

        <!-- ================= MODAL: UBAH NAMA ================= -->
        <div class="modal-overlay" id="nameModal">
            <div class="modal-box">
                <div class="modal-title">Ubah Nama</div>
                <div class="modal-message" id="nameMessage"></div>
                <form id="nameForm">
                    <input type="text" id="nameInput" placeholder="Nama baru" value="{{ e($user->name) }}" required>
                    <input type="password" id="namePassword" placeholder="Password saat ini" required>
                    <div class="modal-actions">
                        <button type="button" class="btn-secondary" onclick="closeModal('nameModal')">Batal</button>
                        <button type="submit" class="btn-primary" id="nameSubmitBtn">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ================= MODAL: UBAH PASSWORD ================= -->
        <div class="modal-overlay" id="passwordModal">
            <div class="modal-box">
                <div class="modal-title">Ubah Password</div>
                <div class="modal-message" id="pwMessage"></div>

                <!-- Step 1: kirim kode ke email -->
                <div class="modal-step active" id="pwStepSend">
                    <p class="modal-hint">Kode verifikasi akan dikirim ke <strong>{{ e($user->email) }}</strong></p>
                    <div class="modal-actions">
                        <button type="button" class="btn-secondary" onclick="closeModal('passwordModal')">Batal</button>
                        <button type="button" class="btn-primary" id="pwSendBtn" onclick="pwSendCode()">Kirim Kode</button>
                    </div>
                </div>

                <!-- Step 2: masukkan kode -->
                <div class="modal-step" id="pwStepCode">
                    <form id="pwCodeForm">
                        <p class="modal-hint">Masukkan kode yang dikirim ke email kamu.</p>
                        <input type="text" id="pwCodeInput" placeholder="Kode verifikasi" required>
                        <div class="modal-actions">
                            <button type="button" class="btn-secondary" onclick="closeModal('passwordModal')">Batal</button>
                            <button type="submit" class="btn-primary" id="pwCodeBtn">Verifikasi</button>
                        </div>
                    </form>
                </div>

                <!-- Step 3: password baru -->
                <div class="modal-step" id="pwStepNew">
                    <form id="pwNewForm">
                        <input type="password" id="pwNew1" placeholder="Password baru" required>
                        <input type="password" id="pwNew2" placeholder="Konfirmasi password baru" required>
                        <div class="modal-actions">
                            <button type="button" class="btn-secondary" onclick="closeModal('passwordModal')">Batal</button>
                            <button type="submit" class="btn-primary" id="pwNewBtn">Simpan Password</button>
                        </div>
                    </form>
                </div>

                <!-- Step 4: sukses -->
                <div class="modal-step" id="pwStepDone">
                    <p class="modal-hint">Password berhasil diubah. Silakan login ulang.</p>
                    <div class="modal-actions">
                        <button type="button" class="btn-primary" onclick="window.location.href='{{ route('logout') }}'">Login Ulang</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-footer />

    <script>
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const userEmail = @json($user->email);
        let resetCode = '';

        function openModal(id) {
            document.getElementById(id).classList.add('open');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('open');
            // Reset form dan message
            const msgBox = document.getElementById(id === 'nameModal' ? 'nameMessage' : 'pwMessage');
            if (msgBox) {
                msgBox.className = 'modal-message';
                msgBox.textContent = '';
            }
        }

        // ============== UPLOAD FOTO PROFIL ==============
        document.getElementById('avatarWrap').addEventListener('click', function() {
            document.getElementById('photoInput').click();
        });

        document.getElementById('photoInput').addEventListener('change', async function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('foto', file);

            try {
                const res = await fetch("{{ route('profile.uploadPhoto') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: formData
                });
                const data = await res.json();

                if (data.success) {
                    const photoBox = document.getElementById('avatarPhoto');
                    photoBox.innerHTML = '<img src="' + data.url_photo + '" id="avatarImg" alt="Foto profil">';
                } else {
                    alert(data.message || 'Gagal mengunggah foto.');
                }
            } catch (err) {
                alert('Terjadi kesalahan saat mengunggah foto.');
            }
        });

        // ============== UBAH NAMA ==============
        document.getElementById('nameForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const name = document.getElementById('nameInput').value.trim();
            const password = document.getElementById('namePassword').value;
            const msgBox = document.getElementById('nameMessage');
            const btn = document.getElementById('nameSubmitBtn');

            msgBox.className = 'modal-message';
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner"></span> Menyimpan...';

            try {
                const res = await fetch("{{ route('profile.updateName') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify({ name: name, password: password })
                });
                const data = await res.json();

                if (data.success) {
                    msgBox.textContent = 'Nama berhasil diubah.';
                    msgBox.className = 'modal-message success';
                    document.getElementById('displayName').textContent = data.name;
                    document.getElementById('rowNameValue').textContent = data.name;
                    setTimeout(() => closeModal('nameModal'), 900);
                } else {
                    msgBox.textContent = data.message || 'Gagal mengubah nama.';
                    msgBox.className = 'modal-message error';
                }
            } catch (err) {
                msgBox.textContent = 'Tidak dapat terhubung ke server.';
                msgBox.className = 'modal-message error';
            } finally {
                btn.disabled = false;
                btn.textContent = 'Simpan';
            }
        });

        // ============== UBAH PASSWORD (alur kode via email) ==============
        function pwShowStep(stepId) {
            document.querySelectorAll('#passwordModal .modal-step').forEach(s => s.classList.remove('active'));
            document.getElementById(stepId).classList.add('active');
            const msgBox = document.getElementById('pwMessage');
            msgBox.className = 'modal-message';
            msgBox.textContent = '';
        }

        async function pwApiRequest(endpoint, data) {
            const res = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify(data)
            });
            return res.json();
        }

        async function pwSendCode() {
            const btn = document.getElementById('pwSendBtn');
            const msgBox = document.getElementById('pwMessage');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner"></span> Mengirim...';

            try {
                const result = await pwApiRequest("{{ route('profile.requestResetCode') }}", {});
                if (result.success) {
                    pwShowStep('pwStepCode');
                    document.getElementById('pwCodeInput').focus();
                } else {
                    msgBox.textContent = result.message || 'Gagal mengirim kode.';
                    msgBox.className = 'modal-message error';
                }
            } catch (err) {
                msgBox.textContent = 'Tidak dapat terhubung ke server.';
                msgBox.className = 'modal-message error';
            } finally {
                btn.disabled = false;
                btn.textContent = 'Kirim Kode';
            }
        }

        document.getElementById('pwCodeForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const code = document.getElementById('pwCodeInput').value.trim();
            const btn = document.getElementById('pwCodeBtn');
            const msgBox = document.getElementById('pwMessage');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner"></span> Memverifikasi...';

            try {
                const result = await pwApiRequest("{{ route('profile.verifyResetCode') }}", { code: code });
                if (result.success) {
                    resetCode = code;
                    pwShowStep('pwStepNew');
                    document.getElementById('pwNew1').focus();
                } else {
                    msgBox.textContent = result.message || 'Kode verifikasi tidak valid.';
                    msgBox.className = 'modal-message error';
                }
            } catch (err) {
                msgBox.textContent = 'Tidak dapat terhubung ke server.';
                msgBox.className = 'modal-message error';
            } finally {
                btn.disabled = false;
                btn.textContent = 'Verifikasi';
            }
        });

        document.getElementById('pwNewForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const p1 = document.getElementById('pwNew1').value;
            const p2 = document.getElementById('pwNew2').value;
            const btn = document.getElementById('pwNewBtn');
            const msgBox = document.getElementById('pwMessage');

            if (p1 !== p2) {
                msgBox.textContent = 'Konfirmasi password tidak cocok.';
                msgBox.className = 'modal-message error';
                return;
            }

            if (p1.length < 6) {
                msgBox.textContent = 'Password minimal 6 karakter.';
                msgBox.className = 'modal-message error';
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner"></span> Memproses...';

            try {
                const result = await pwApiRequest("{{ route('profile.resetPassword') }}", {
                    newPassword: p1,
                    confirmPassword: p2
                });
                if (result.success) {
                    pwShowStep('pwStepDone');
                } else {
                    msgBox.textContent = result.message || 'Gagal mengubah password.';
                    msgBox.className = 'modal-message error';
                }
            } catch (err) {
                msgBox.textContent = 'Tidak dapat terhubung ke server.';
                msgBox.className = 'modal-message error';
            } finally {
                btn.disabled = false;
                btn.textContent = 'Simpan Password';
            }
        });

        // Auto focus ke input kode saat step berubah
        document.addEventListener('DOMContentLoaded', function() {
            const codeInput = document.getElementById('pwCodeInput');
            if (codeInput) {
                codeInput.addEventListener('input', function() {
                    if (this.value.length === 6) {
                        document.getElementById('pwCodeForm').dispatchEvent(new Event('submit'));
                    }
                });
            }
        });
    </script>

</body>
</html>