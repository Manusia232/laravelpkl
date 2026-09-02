<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandingkan Semua - EV Compare</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* ==================== SECTION 1 - HERO ==================== */
        .hero-section {
            position: relative;
            width: 100%;
            min-height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.25), rgba(0, 0, 0, 0.25)),
                        url('{{ asset("https://www.byd.com/material/dm-i-into/BYD%20M6%20DM%20DuaL%20Mode%20Technology_Desktop.jpg") }}') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .hero-content {
            text-align: center;
            color: #ffffff;
            max-width: 650px;
            width: 100%;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            letter-spacing: -1px;
            margin-bottom: 8px;
        }

        .hero-subtitle {
            font-size: 1.1rem;
            font-weight: 400;
            color: #e0e0e0;
            margin-bottom: 30px;
        }

        .compare-box {
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 100%;
        }

.input-group {
    position: relative;
    width: 100%;
    margin-top: 15px;
}

.input-group input {
    width: 100%;
    padding: 14px 45px 14px 20px;
    border-radius: 25px;
    border: 1px solid rgba(255, 255, 255, 0.8);
    background: rgba(255, 255, 255, 0.95);
    font-size: 0.95rem;
    color: #333;
    outline: none;
    font-weight: 500;
    box-sizing: border-box;
}

.input-group input:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
}


        .remove-btn {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 1.2rem;
            color: #666;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 50%;
            transition: background 0.2s ease;
        }

        .remove-btn:hover {
            background: rgba(0, 0, 0, 0.1);
            color: #000;
        }

        .action-row {
            display: flex;
            gap: 10px;
            width: 100%;
            position: relative;
        }

.search-container {
    display: flex;
    width: 100%;
    gap: 10px;
}

.input-search {
    flex: 1;
    width: 100%;
    min-width: 0;
    padding: 14px 20px;
    border-radius: 25px;
    border: 1px solid rgba(255, 255, 255, 0.8);
    background: rgba(255, 255, 255, 0.95);
    font-size: 0.9rem;
    outline: none;
    color: #333;
    box-sizing: border-box;
}


        .btn-compare {
            padding: 14px 28px;
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.4);
            background: #1a1a1a;
            color: #ffffff;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .btn-compare:hover {
            background: #333333;
        }

        .btn-compare:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Search Results */
        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.15);
            max-height: 300px;
            overflow-y: auto;
            display: none;
            z-index: 1000;
            margin-top: 4px;
        }

        .search-results.active {
            display: block;
        }

        .search-result-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            cursor: pointer;
            transition: background 0.15s ease;
            border-bottom: 1px solid #f0f0f0;
        }

        .search-result-item:hover {
            background: #f3f4f6;
        }

        .search-result-item:last-child {
            border-bottom: none;
        }

        .search-result-item img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
            background: #f3f4f6;
        }

        .search-result-info {
            flex: 1;
        }

        .search-result-name {
            font-weight: 600;
            color: #1a1a2e;
            font-size: 0.9rem;
        }

        .search-result-brand {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .search-result-add {
            background: #2563eb;
            color: white;
            border: none;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .search-result-add:hover {
            background: #1d4ed8;
        }

        .search-result-add:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* ==================== SECTION 2 - STATS & KATEGORI ==================== */
        .section-2 {
            width: 100%;
            min-height: 50vh;
            background-color: #f3f5fa;
            padding: 30px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .sec2-container {
            max-width: 1100px;
            width: 100%;
            margin: 0 auto;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 8px;
        }

        .stat-card {
            background: #ffffff;
            padding: 16px 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        }

        .stat-card h2 {
            font-size: 1.6rem;
            font-weight: 800;
            color: #1e3a8a;
            margin-bottom: 4px;
        }

        .stat-card p {
            font-size: 0.8rem;
            color: #555555;
            font-weight: 600;
        }

        .last-updated {
            text-align: center;
            font-size: 0.7rem;
            color: #888888;
            margin-bottom: 25px;
        }

        .category-header {
            position: relative;
            text-align: center;
            margin-bottom: 25px;
        }

        .category-header::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 1px;
            background-color: #d1d5db;
            z-index: 1;
        }

        .category-header h3 {
            position: relative;
            display: inline-block;
            background-color: #f3f5fa;
            padding: 0 15px;
            font-size: 1.1rem;
            font-weight: 700;
            color: #111827;
            z-index: 2;
        }

        /* --- Ini bagian yang dikembalikan ke desain asli (gambar per kategori, bukan bubble icon generik) --- */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 15px;
            align-items: end;
        }

        .category-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            cursor: pointer;
            transition: transform 0.2s ease;
            text-decoration: none;
        }

        .category-item:hover {
            transform: translateY(-4px);
        }

        .category-item img {
            max-width: 100%;
            height: 60px;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .category-item span {
            font-size: 0.75rem;
            font-weight: 700;
            color: #1f2937;
            line-height: 1.2;
        }

        .category-item .cat-count {
            display: block;
            margin-top: 2px;
            font-size: 0.65rem;
            color: #6b7280;
            font-weight: 500;
        }

        /* Toast Notification */
        .toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #1a1a2e;
            color: white;
            padding: 14px 24px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            font-size: 0.9rem;
            font-weight: 500;
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.4s ease;
            z-index: 9999;
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        .toast.success { background: #16a34a; }
        .toast.error { background: #dc2626; }
        .toast.warning { background: #f59e0b; }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title { font-size: 2.3rem; }
            .action-row { flex-direction: column; }
            .btn-compare { width: 100%; }
            .section-2 { min-height: auto; padding: 20px 15px; }
            .stats-grid { grid-template-columns: 1fr; gap: 10px; }
            .category-grid { grid-template-columns: repeat(2, 1fr); gap: 20px; }
            .search-results {
                position: fixed;
                top: auto;
                bottom: 80px;
                left: 20px;
                right: 20px;
                max-height: 200px;
            }
        }

        @media (max-width: 480px) {
            .hero-title { font-size: 1.8rem; }
            .stats-grid { grid-template-columns: 1fr; }
            .category-grid { grid-template-columns: repeat(2, 1fr); gap: 15px; }
        }
    </style>
</head>

<body>
    @include('components.navbar')

    <!-- ==================== SECTION 1 - HERO ==================== -->
    <section class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">bandingkan semua</h1>
            <p class="hero-subtitle">sepeda, motor, mobil, truk, dan banyak lagi</p>

            <div class="compare-box" id="compareBox">
                <div id="selectedModelsContainer">
                    @foreach($selectedModels as $model)
                        <div class="input-group" data-id="{{ $model->id }}">
                            <input type="text" value="{{ $model->model_name }} - {{ $model->brand->brand_name ?? '' }}" readonly>
                            <button class="remove-btn" type="button" onclick="removeModel({{ $model->id }})">&times;</button>
                        </div>
                    @endforeach
                </div>

                <div class="action-row">
                    <div style="flex:1; position:relative;">
                        <input type="text" class="input-search" id="searchInput" placeholder="Ketik di sini untuk membandingkan" autocomplete="off">
                        <div class="search-results" id="searchResults"></div>
                    </div>
                    <button class="btn-compare" id="compareBtn" onclick="goToCompare()"
                            {{ count($selectedModels) < 2 ? 'disabled' : '' }}>
                        Bandingkan
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- ==================== SECTION 2 - STATS & KATEGORI ==================== -->
    <section class="section-2">
        <div class="sec2-container">

            <div class="stats-grid">
                <div class="stat-card">
                    <h2>{{ number_format($totalModels) }}+</h2>
                    <p>Kendaraan Listrik</p>
                </div>
                <div class="stat-card">
                    <h2>{{ number_format($totalBrands) }}+</h2>
                    <p>Produsen EV</p>
                </div>
                <div class="stat-card">
                    <h2>{{ number_format($totalCategories) }}</h2>
                    <p>Kategori EV</p>
                </div>
            </div>

            <p class="last-updated">Terakhir di perbarui: {{ now()->format('d F Y') }}</p>

            <div class="category-header">
                <h3>Mencari {{ number_format($totalModels) }}+ Kendaraan listrik</h3>
            </div>

            <div class="category-grid">
                @foreach($categories as $category)
                    <a href="{{ route('models.index', ['type_id' => $category->id]) }}" class="category-item">
                        {{-- Pakai icon/gambar per kategori dari database kalau ada,
                             fallback ke file di public/images/categories/{slug}.png,
                             fallback terakhir ke gambar default supaya gak putus --}}
                        <img
                            src="{{ $category->icon_url ?? asset('images/categories/' . \Illuminate\Support\Str::slug($category->type_name) . '.png') }}"
                            alt="{{ $category->type_name }}"
                            onerror="this.onerror=null;this.src='{{ asset('images/categories/default.png') }}'">
                        <span>{{ $category->type_name }}</span>
                        <span class="cat-count">{{ $category->models_count }} model</span>
                    </a>
                @endforeach
            </div>

        </div>
    </section>

    <!-- Toast Notification -->
    <div class="toast" id="toast"></div>

    <script>
        // ==========================================
        // KONFIGURASI
        // ==========================================
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const MAX_COMPARE = 4;
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        const selectedContainer = document.getElementById('selectedModelsContainer');
        const compareBtn = document.getElementById('compareBtn');
        let searchTimeout = null;
        let isSearching = false;

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = 'toast ' + type;
            void toast.offsetWidth;
            toast.classList.add('show');
            clearTimeout(toast._timeout);
            toast._timeout = setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        function updateCompareButton() {
            const items = selectedContainer.querySelectorAll('.input-group');
            const count = items.length;
            if (count >= 2) {
                compareBtn.disabled = false;
                compareBtn.textContent = 'Bandingkan (' + count + ')';
            } else {
                compareBtn.disabled = true;
                compareBtn.textContent = 'Bandingkan';
            }
        }

        function addModelToCompare(id, name, brand) {
            const existing = selectedContainer.querySelector(`[data-id="${id}"]`);
            if (existing) {
                showToast('Kendaraan sudah ada di daftar perbandingan.', 'warning');
                return;
            }

            const currentCount = selectedContainer.querySelectorAll('.input-group').length;
            if (currentCount >= MAX_COMPARE) {
                showToast('Maksimal ' + MAX_COMPARE + ' kendaraan dapat dibandingkan.', 'error');
                return;
            }

            fetch('{{ route("landing.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const div = document.createElement('div');
                    div.className = 'input-group';
                    div.dataset.id = id;
                    div.innerHTML = `
                        <input type="text" value="${name} - ${brand}" readonly>
                        <button class="remove-btn" type="button" onclick="removeModel(${id})">&times;</button>
                    `;
                    selectedContainer.appendChild(div);
                    updateCompareButton();
                    showToast(data.message || 'Kendaraan berhasil ditambahkan.', 'success');
                    searchInput.value = '';
                    searchResults.classList.remove('active');
                } else {
                    showToast(data.message || 'Gagal menambahkan kendaraan.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
            });
        }

        function removeModel(id) {
            const item = selectedContainer.querySelector(`[data-id="${id}"]`);
            if (!item) return;

            fetch('{{ route("landing.remove") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    item.remove();
                    updateCompareButton();
                    showToast(data.message || 'Kendaraan dihapus dari daftar.', 'success');
                } else {
                    showToast(data.message || 'Gagal menghapus kendaraan.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Terjadi kesalahan. Silakan coba lagi.', 'error');
            });
        }

        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            clearTimeout(searchTimeout);
            if (query.length < 2) {
                searchResults.classList.remove('active');
                return;
            }
            searchTimeout = setTimeout(() => {
                performSearch(query);
            }, 300);
        });

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.action-row')) {
                searchResults.classList.remove('active');
            }
        });

        function performSearch(query) {
            if (isSearching) return;
            isSearching = true;

            fetch('{{ route("landing.search") }}?q=' + encodeURIComponent(query))
                .then(response => response.json())
                .then(data => {
                    searchResults.innerHTML = '';
                    if (data.length === 0) {
                        searchResults.innerHTML = `
                            <div style="padding: 12px 16px; color: #6b7280; text-align: center; font-size: 0.9rem;">
                                <i class="fas fa-search"></i> Tidak ada hasil ditemukan
                            </div>
                        `;
                    } else {
                        data.forEach(model => {
                            const div = document.createElement('div');
                            div.className = 'search-result-item';
                            const isAdded = selectedContainer.querySelector(`[data-id="${model.id}"]`) !== null;
                            div.innerHTML = `
                                <img src="${model.url_photo || ''}" alt="${model.name}" onerror="this.style.display='none'">
                                <div class="search-result-info">
                                    <div class="search-result-name">${model.name}</div>
                                    <div class="search-result-brand">${model.brand} ${model.type ? '· ' + model.type : ''}</div>
                                </div>
                                <button class="search-result-add" onclick="addModelToCompare(${model.id}, '${model.name}', '${model.brand}')" ${isAdded ? 'disabled' : ''}>
                                    ${isAdded ? '✓' : '+'}
                                </button>
                            `;
                            searchResults.appendChild(div);
                        });
                    }
                    searchResults.classList.add('active');
                })
                .catch(error => {
                    console.error('Error:', error);
                })
                .finally(() => {
                    isSearching = false;
                });
        }

        function goToCompare() {
            const items = selectedContainer.querySelectorAll('.input-group');
            if (items.length < 2) {
                showToast('Minimal 2 kendaraan untuk dibandingkan.', 'warning');
                return;
            }
            window.location.href = '{{ route("compare.result") }}';
        }

        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const firstResult = searchResults.querySelector('.search-result-item');
                if (firstResult) {
                    const addBtn = firstResult.querySelector('.search-result-add');
                    if (addBtn && !addBtn.disabled) {
                        addBtn.click();
                    }
                }
            }
            if (e.key === 'Escape') {
                searchResults.classList.remove('active');
                this.blur();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            updateCompareButton();
            setTimeout(() => {
                searchInput.focus();
            }, 500);
        });
    </script>
<x-footer />
</body>
</html>
