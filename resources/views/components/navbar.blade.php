<nav class="ev-navbar">
    <div class="ev-navbar__top">

        {{-- LOGO --}}
        <div class="ev-navbar__logo">
            <a href="{{ route('landing') }}">
                <span>EVERSUS</span>
            </a>
        </div>

        {{-- DESKTOP SEARCH --}}
        <div class="ev-navbar__search ev-navbar__search--desktop">
            <span class="ev-navbar__search-icon">
                <img
                    src="https://img.icons8.com/?size=512&id=12773&format=png"
                    alt="Search"
                >
            </span>

            <input
                type="text"
                id="evNavbarSearch"
                placeholder="Cari kendaraan..."
                autocomplete="off"
            >

            <div
                class="ev-navbar__search-results"
                id="evNavbarSearchResults"
            ></div>
        </div>

        {{-- DESKTOP NAVIGATION --}}
        <div class="ev-navbar__links ev-navbar__links--desktop">

            <div class="ev-navbar__dropdown" id="evNavbarDropdown">
                <button
                    class="ev-navbar__dropdown-btn"
                    type="button"
                    id="evNavbarDropdownBtn"
                >
                    JENIS KENDARAAN
                    <span class="ev-navbar__arrow">▼</span>
                </button>

                <div class="ev-navbar__dropdown-content" id="evNavbarDropdownContent">

                    <a href="{{ route('models.index') }}">
                        Semua Kendaraan
                    </a>

                    <a href="{{ route('models.index', ['sort' => 'newest']) }}">
                        Terbaru
                    </a>

                    @foreach(\App\Models\Type::limit(5)->get() as $type)
                        <a href="{{ route('models.index', ['type_id' => $type->id]) }}">
                            {{ $type->type_name }}
                        </a>
                    @endforeach

                </div>
            </div>

            <a href="{{ route('landing.index') }}">BERANDA</a>
            <a href="{{ route('brands.index') }}">MEREK</a>
            <a href="{{ route('models.index') }}">MODEL</a>

            {{-- COMPARE --}}
            <div
                class="ev-navbar__compare"
                title="Bandingkan Kendaraan"
            >
                <a href="{{ route('compare.index') }}">

                    <img
                        src="https://img.icons8.com/?size=512w&id=12928&format=png"
                        alt="Compare"
                        class="ev-navbar__compare-img"
                    >

                    <span
                        class="ev-navbar__compare-badge"
                        id="evNavbarCompareBadge"
                    >
                        {{ count(session('compare', [])) }}
                    </span>

                </a>
            </div>

        </div>

        {{-- MOBILE MENU BUTTON --}}
        <button
            class="ev-navbar__menu-toggle"
            id="evNavbarMenuToggle"
            type="button"
            aria-label="Buka menu"
            aria-expanded="false"
        >
            ☰
        </button>

        {{-- PROFILE --}}
        <div class="ev-navbar__icons">

            <div
                class="ev-navbar__profile"
                title="Profil Akun"
            >

                @auth

                    <a href="{{ route('profile.index') }}">

                        @if(Auth::user()->url_photo)

                            <img
                                src="{{ Auth::user()->url_photo }}"
                                alt="Profile"
                                class="ev-navbar__profile-img"
                            >

                        @else

                            <div class="ev-navbar__profile-placeholder">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>

                        @endif

                    </a>

                @else

                    <a
                        href="{{ route('login') }}"
                        class="ev-navbar__login"
                    >
                        Login
                    </a>

                @endauth

            </div>

        </div>

    </div>


    {{-- MOBILE SEARCH --}}
    <div class="ev-navbar__mobile-search-wrapper">

        <div class="ev-navbar__search">

            <span class="ev-navbar__search-icon">
                <img
                    src="https://img.icons8.com/?size=512&id=12773&format=png"
                    alt="Search"
                >
            </span>

            <input
                type="text"
                id="evNavbarSearchMobile"
                placeholder="Cari kendaraan..."
                autocomplete="off"
            >

            <div
                class="ev-navbar__search-results"
                id="evNavbarSearchResultsMobile"
            ></div>

        </div>

    </div>


    {{-- MOBILE NAVIGATION --}}
    <div
        class="ev-navbar__mobile-links"
        id="evNavbarMobileLinks"
    >

        <div class="ev-navbar__dropdown">

            <button
                class="ev-navbar__dropdown-btn"
                type="button"
                id="evNavbarMobileDropdownBtn"
            >
                JENIS KENDARAAN
                <span class="ev-navbar__arrow">▼</span>
            </button>

            <div class="ev-navbar__dropdown-content">

                <a href="{{ route('models.index') }}">
                    Semua Kendaraan
                </a>

                <a href="{{ route('models.index', ['sort' => 'newest']) }}">
                    Terbaru
                </a>

                @foreach(\App\Models\Type::limit(5)->get() as $type)

                    <a href="{{ route('models.index', ['type_id' => $type->id]) }}">
                        {{ $type->type_name }}
                    </a>

                @endforeach

            </div>

        </div>

        <a href="{{ route('landing.index', ['type_id' => 1]) }}">
            HOME
        </a>

        <a href="{{ route('models.index', ['type_id' => 2]) }}">
            MOTOR
        </a>

        <a href="{{ route('models.index', ['type_id' => 3]) }}">
            MOBIL
        </a>

        <div
            class="ev-navbar__compare"
            title="Bandingkan Kendaraan"
        >

            <a href="{{ route('compare.index') }}">

                <img
                    src="https://png.pngtree.com/png-clipart/20191121/original/pngtree-simply-weight-icon-compare-logo-symbol-scales-judgment-pictogram-ui-comparison-png-image_5097992.jpg"
                    alt="Compare"
                    class="ev-navbar__compare-img"
                >

                {{-- <span class="ev-navbar__compare-badge">
                    {{ count(session('compare', [])) }}
                </span> --}}

            </a>

        </div>

    </div>

</nav>


<style>
/* =========================================================
   EVERSUS NAVBAR
   SEMUA CSS DI-SCOPE KE .ev-navbar
   ========================================================= */

.ev-navbar {
    width: 100%;
    background: #121212;
    color: #ffffff;
    position: relative;
    z-index: 1000;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.25);

    font-family:
        Arial,
        sans-serif;
}

/* Jangan gunakan * global */
.ev-navbar *,
.ev-navbar *::before,
.ev-navbar *::after {
    box-sizing: border-box;
}


/* =========================================================
   TOP
   ========================================================= */

.ev-navbar__top {
    width: 100%;
    min-height: 64px;

    padding: 10px 32px;

    display: flex;
    align-items: center;

    gap: 50px;
}


/* =========================================================
   LOGO
   ========================================================= */

.ev-navbar__logo {
    flex-shrink: 0;
}

.ev-navbar__logo a {
    color: #ffffff;
    text-decoration: none;
}

.ev-navbar__logo span {
    display: block;

    font-size: 1.4rem;
    font-weight: 800;

    letter-spacing: 1.5px;

    white-space: nowrap;
}


/* =========================================================
   SEARCH
   ========================================================= */

.ev-navbar__search {
    position: relative;

    display: flex;
    align-items: center;

    min-width: 0;
}

.ev-navbar__search--desktop {
    flex: 1;

    max-width: 360px;

    margin-left: 5px;
}

.ev-navbar__search-icon {
    position: absolute;

    left: 13px;

    z-index: 2;

    width: 18px;
    height: 18px;

    pointer-events: none;
}

.ev-navbar__search-icon img {
    width: 100%;
    height: 100%;

    object-fit: contain;

    display: block;
}

.ev-navbar__search input {
    width: 100%;
    min-width: 0;

    height: 40px;

    padding: 8px 14px 8px 38px;

    border-radius: 20px;
    border: 1px solid #333333;

    outline: none;

    background: #1e1e1e;

    color: #ffffff;

    font-family: Arial, sans-serif;
    font-size: 0.85rem;

    transition:
        border-color 0.2s ease,
        background 0.2s ease,
        box-shadow 0.2s ease;
}

.ev-navbar__search input:focus {
    border-color: #2563eb;

    background: #222222;

    box-shadow:
        0 0 0 3px rgba(37, 99, 235, 0.12);
}

.ev-navbar__search input::placeholder {
    color: #666666;
}


/* =========================================================
   SEARCH RESULTS
   ========================================================= */

.ev-navbar__search-results {
    position: absolute;

    top: calc(100% + 8px);

    left: 0;
    right: 0;

    background: #1e1e1e;

    border: 1px solid #333333;

    border-radius: 10px;

    box-shadow:
        0 10px 35px rgba(0, 0, 0, 0.5);

    max-height: 350px;

    overflow-y: auto;

    display: none;

    z-index: 5000;
}

.ev-navbar__search-results.active {
    display: block;
}

.ev-navbar__search-results::-webkit-scrollbar {
    width: 6px;
}

.ev-navbar__search-results::-webkit-scrollbar-track {
    background: #1e1e1e;
}

.ev-navbar__search-results::-webkit-scrollbar-thumb {
    background: #444444;
    border-radius: 3px;
}


/* =========================================================
   SEARCH ITEM
   ========================================================= */

.ev-navbar__search-item {
    display: flex;
    align-items: center;

    gap: 12px;

    padding: 10px 14px;

    cursor: pointer;

    border-bottom: 1px solid #2a2a2a;

    transition:
        background 0.15s ease;
}

.ev-navbar__search-item:hover {
    background: #2a2a2a;
}

.ev-navbar__search-item:last-child {
    border-bottom: none;
}

.ev-navbar__search-item > img {
    width: 38px;
    height: 38px;

    flex-shrink: 0;

    border-radius: 6px;

    object-fit: cover;

    background: #2a2a2a;
}

.ev-navbar__search-info {
    flex: 1;
    min-width: 0;
}

.ev-navbar__search-name {
    color: #ffffff;

    font-size: 0.85rem;

    font-weight: 600;

    white-space: nowrap;

    overflow: hidden;

    text-overflow: ellipsis;
}

.ev-navbar__search-brand {
    color: #888888;

    font-size: 0.7rem;

    margin-top: 2px;
}

.ev-navbar__search-actions {
    display: flex;
    align-items: center;

    gap: 6px;

    flex-shrink: 0;
}

.ev-navbar__search-btn {
    padding: 5px 9px;

    border: none;

    border-radius: 5px;

    font-size: 0.7rem;

    font-weight: 600;

    cursor: pointer;

    text-decoration: none;

    transition:
        background 0.15s ease,
        opacity 0.15s ease;
}

.ev-navbar__search-btn--detail {
    background: #2563eb;
    color: #ffffff;
}

.ev-navbar__search-btn--detail:hover {
    background: #1d4ed8;
}

.ev-navbar__search-btn--compare {
    background: #16a34a;
    color: #ffffff;
}

.ev-navbar__search-btn--compare:hover {
    background: #15803d;
}

.ev-navbar__search-btn--compare:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.ev-navbar__search-empty {
    padding: 18px;

    text-align: center;

    color: #777777;

    font-size: 0.85rem;
}


/* =========================================================
   DESKTOP NAVIGATION
   ========================================================= */

.ev-navbar__links {
    display: flex;
    align-items: center;

    justify-content: flex-start;

    gap: 20px;

    flex-shrink: 0;

    padding: 0;
    margin: 0;
}

.ev-navbar__links > a,
.ev-navbar__dropdown-btn {
    color: #cccccc;

    text-decoration: none;

    font-family: Arial, sans-serif;

    font-size: 0.72rem;

    font-weight: 600;

    letter-spacing: 0.4px;

    white-space: nowrap;

    transition: color 0.2s ease;
}

.ev-navbar__links > a:hover,
.ev-navbar__dropdown-btn:hover {
    color: #ffffff;
}


/* =========================================================
   DROPDOWN - PERBAIKAN UTAMA DI SINI
   ========================================================= */

.ev-navbar__dropdown {
    position: relative;

    flex-shrink: 0;
}

.ev-navbar__dropdown-btn {
    display: flex;
    align-items: center;

    gap: 5px;

    padding: 0;

    border: none;

    background: none;

    cursor: pointer;
}

.ev-navbar__arrow {
    font-size: 0.55rem;

    transition:
        transform 0.2s ease;
}

.ev-navbar__dropdown.active
.ev-navbar__arrow {
    transform: rotate(180deg);
}

.ev-navbar__dropdown-content {
    display: none;

    position: absolute;

    top: calc(100% + 10px);
    left: 0;

    min-width: 190px;

    padding: 5px 0;

    background: #1e1e1e;

    border: 1px solid #333333;

    border-radius: 8px;

    box-shadow:
        0 10px 30px rgba(0, 0, 0, 0.4);

    z-index: 4000;
}

/* PERBAIKAN: Hover dengan delay dan transisi */
@media (min-width: 901px) {
    .ev-navbar__dropdown-content {
        opacity: 0;
        visibility: hidden;
        transform: translateY(-5px);
        transition:
            opacity 0.15s ease,
            visibility 0.15s ease,
            transform 0.15s ease;
        pointer-events: none;
        display: block !important;
    }

    .ev-navbar__dropdown:hover .ev-navbar__dropdown-content,
    .ev-navbar__dropdown.active .ev-navbar__dropdown-content {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
        pointer-events: auto;
        display: block !important;
    }

    /* Perbaikan: Tambahkan delay saat keluar */
    .ev-navbar__dropdown-content {
        transition-delay: 0s;
    }

    .ev-navbar__dropdown:hover .ev-navbar__dropdown-content {
        transition-delay: 0.05s;
    }

    /* Area aman di antara tombol dan dropdown */
    .ev-navbar__dropdown-content::before {
        content: '';
        position: absolute;
        top: -10px;
        left: 0;
        right: 0;
        height: 10px;
        background: transparent;
    }
}

.ev-navbar__dropdown-content a {
    display: block;

    padding: 9px 14px;

    color: #cccccc;

    text-decoration: none;

    font-family: Arial, sans-serif;

    font-size: 0.75rem;
}

.ev-navbar__dropdown-content a:hover {
    color: #ffffff;

    background: #2a2a2a;
}

/* Perbaikan: Mode aktif untuk klik */
.ev-navbar__dropdown.active .ev-navbar__dropdown-content {
    display: block;
}


/* =========================================================
   COMPARE
   ========================================================= */

.ev-navbar__compare {
    position: relative;

    display: flex;
    align-items: center;

    flex-shrink: 0;
}

.ev-navbar__compare a {
    display: flex;
    align-items: center;

    text-decoration: none;
}

.ev-navbar__compare-img {
    width: 30px;
    height: 30px;

    border-radius: 50%;

    object-fit: cover;

    border: 1px solid #444444;
}

.ev-navbar__compare-badge {
    position: absolute;

    top: -7px;
    right: -7px;

    width: 18px;
    height: 18px;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #2563eb;

    color: #ffffff;

    font-size: 0.6rem;

    font-weight: 700;

    border-radius: 50%;

    border: 2px solid #121212;
}


/* =========================================================
   PROFILE
   ========================================================= */

.ev-navbar__icons {
    display: flex;
    align-items: center;

    flex-shrink: 0;

    margin-left: auto;
}

.ev-navbar__profile {
    display: flex;
    align-items: center;
}

.ev-navbar__profile a {
    display: flex;
    align-items: center;

    text-decoration: none;
}

.ev-navbar__profile-img,
.ev-navbar__profile-placeholder {
    width: 34px;
    height: 34px;

    border-radius: 50%;
}

.ev-navbar__profile-img {
    object-fit: cover;

    border: 1px solid #444444;
}

.ev-navbar__profile-placeholder {
    display: flex;
    align-items: center;
    justify-content: center;

    background: #2563eb;

    color: #ffffff;

    font-size: 0.85rem;

    font-weight: 700;
}

.ev-navbar__login {
    color: #cccccc;

    font-family: Arial, sans-serif;

    font-size: 0.75rem;

    font-weight: 600;
}


/* =========================================================
   MOBILE BUTTON
   ========================================================= */

.ev-navbar__menu-toggle {
    display: none;

    width: 40px;
    height: 40px;

    flex-shrink: 0;

    align-items: center;
    justify-content: center;

    padding: 0;

    border: none;

    border-radius: 8px;

    background: transparent;

    color: #ffffff;

    font-family: Arial, sans-serif;

    font-size: 1.45rem;

    cursor: pointer;
}

.ev-navbar__menu-toggle:hover {
    background: #222222;
}


/* =========================================================
   MOBILE SEARCH
   ========================================================= */

.ev-navbar__mobile-search-wrapper {
    display: none;
}


/* =========================================================
   MOBILE NAV
   ========================================================= */

.ev-navbar__mobile-links {
    display: none;
}


/* =========================================================
   TOAST
   ========================================================= */

.ev-navbar__toast {
    position: fixed;

    right: 30px;
    bottom: 30px;

    background: #1a1a2e;

    color: #ffffff;

    padding: 12px 20px;

    border-radius: 10px;

    box-shadow:
        0 4px 20px rgba(0, 0, 0, 0.2);

    font-family: Arial, sans-serif;

    font-size: 0.85rem;

    font-weight: 500;

    transform: translateY(100px);

    opacity: 0;

    transition:
        all 0.4s ease;

    z-index: 9999;
}

.ev-navbar__toast.show {
    transform: translateY(0);
    opacity: 1;
}

.ev-navbar__toast.success {
    background: #16a34a;
}

.ev-navbar__toast.error {
    background: #dc2626;
}

.ev-navbar__toast.warning {
    background: #f59e0b;
}


/* =========================================================
   TABLET
   ========================================================= */

@media (max-width: 1100px) and (min-width: 901px) {

    .ev-navbar__top {
        gap: 30px;

        padding-left: 20px;
        padding-right: 20px;
    }

    .ev-navbar__search--desktop {
        max-width: 280px;
    }

    .ev-navbar__links {
        gap: 13px;
    }

    .ev-navbar__links > a,
    .ev-navbar__dropdown-btn {
        font-size: 0.65rem;
    }

    .ev-navbar__logo span {
        font-size: 1.2rem;
    }

}


/* =========================================================
   MOBILE
   ========================================================= */

@media (max-width: 900px) {

    .ev-navbar__top {
        min-height: 60px;

        padding: 9px 16px;

        gap: 10px;
    }

    .ev-navbar__logo {
        flex-shrink: 0;
    }

    .ev-navbar__logo span {
        font-size: 1.15rem;

        letter-spacing: 1px;
    }

    .ev-navbar__search--desktop {
        display: none;
    }

    .ev-navbar__links--desktop {
        display: none;
    }

    .ev-navbar__menu-toggle {
        display: flex;

        margin-left: auto;
    }

    .ev-navbar__icons {
        margin-left: 0;
    }

    .ev-navbar__mobile-search-wrapper {
        display: block;

        padding: 0 16px 12px;
    }

    .ev-navbar__mobile-search-wrapper
    .ev-navbar__search {
        width: 100%;

        max-width: none;

        margin: 0;
    }

    .ev-navbar__mobile-search-wrapper input {
        height: 42px;

        font-size: 0.85rem;
    }

    .ev-navbar__mobile-links {
        display: none;

        flex-direction: column;

        align-items: stretch;
        justify-content: flex-start;

        width: 100%;

        padding: 8px 16px 18px;

        gap: 0;

        background: #1e1e1e;

        border-top: 1px solid #292929;

        box-shadow:
            0 10px 25px rgba(0, 0, 0, 0.4);
    }

    .ev-navbar__mobile-links.active {
        display: flex;
    }

    .ev-navbar__mobile-links > a,
    .ev-navbar__mobile-links
    .ev-navbar__dropdown-btn {

        width: 100%;

        min-height: 44px;

        display: flex;
        align-items: center;

        padding: 10px 4px;

        border-bottom: 1px solid #292929;

        color: #cccccc;

        text-decoration: none;

        font-family: Arial, sans-serif;

        font-size: 0.78rem;

        font-weight: 600;

        letter-spacing: 0.5px;
    }

    .ev-navbar__mobile-links
    .ev-navbar__dropdown {
        width: 100%;
    }

    .ev-navbar__mobile-links
    .ev-navbar__dropdown-btn {
        justify-content: space-between;
    }

    .ev-navbar__mobile-links
    .ev-navbar__dropdown-content {

        position: static;

        width: 100%;

        min-width: 0;

        margin: 0;

        padding: 0;

        border: none;

        border-radius: 6px;

        background: #252525;

        box-shadow: none;
    }

    .ev-navbar__mobile-links
    .ev-navbar__dropdown.active
    .ev-navbar__dropdown-content {
        display: block;
    }

    .ev-navbar__mobile-links
    .ev-navbar__dropdown-content a {

        min-height: 40px;

        display: flex;
        align-items: center;

        padding: 9px 14px;

        border-bottom: 1px solid #303030;

        color: #cccccc;
    }

    .ev-navbar__mobile-links
    .ev-navbar__compare {
        padding: 12px 4px 4px;
    }

    .ev-navbar__search-results {

        top: calc(100% + 6px);

        left: 0;
        right: 0;

        max-height: 55vh;

        border-radius: 10px;
    }

}


/* =========================================================
   HP
   ========================================================= */

@media (max-width: 480px) {

    .ev-navbar__top {
        padding: 8px 12px;

        gap: 8px;
    }

    .ev-navbar__logo span {
        font-size: 1rem;

        letter-spacing: 0.8px;
    }

    .ev-navbar__menu-toggle {
        width: 36px;
        height: 36px;

        font-size: 1.3rem;
    }

    .ev-navbar__profile-img,
    .ev-navbar__profile-placeholder {

        width: 32px;
        height: 32px;
    }

    .ev-navbar__mobile-search-wrapper {
        padding: 0 12px 10px;
    }

    .ev-navbar__mobile-search-wrapper input {
        height: 40px;
    }

    .ev-navbar__mobile-links {
        padding: 6px 12px 16px;
    }

    .ev-navbar__search-item {
        gap: 8px;

        padding: 9px 10px;
    }

    .ev-navbar__search-item > img {
        width: 34px;
        height: 34px;
    }

    .ev-navbar__search-actions {
        gap: 4px;
    }

    .ev-navbar__search-btn {
        padding: 5px 7px;

        font-size: 0.65rem;
    }

}


/* =========================================================
   HP KECIL
   ========================================================= */

@media (max-width: 360px) {

    .ev-navbar__top {
        padding: 8px 10px;
    }

    .ev-navbar__logo span {
        font-size: 0.95rem;
    }

    .ev-navbar__mobile-search-wrapper {
        padding: 0 10px 10px;
    }

    .ev-navbar__mobile-links {
        padding-left: 10px;
        padding-right: 10px;
    }

    .ev-navbar__search-name {
        font-size: 0.78rem;
    }

    .ev-navbar__search-brand {
        font-size: 0.65rem;
    }

    .ev-navbar__search-btn {
        padding: 4px 6px;

        font-size: 0.6rem;
    }

}
</style>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const navbar = document.querySelector('.ev-navbar');

    if (!navbar) {
        return;
    }


    /* =====================================================
       ELEMENT
       ===================================================== */

    const menuToggle =
        navbar.querySelector('#evNavbarMenuToggle');

    const mobileNavLinks =
        navbar.querySelector('#evNavbarMobileLinks');

    const searchInput =
        navbar.querySelector('#evNavbarSearch');

    const searchResults =
        navbar.querySelector('#evNavbarSearchResults');

    const searchInputMobile =
        navbar.querySelector('#evNavbarSearchMobile');

    const searchResultsMobile =
        navbar.querySelector('#evNavbarSearchResultsMobile');

    const mobileDropdownBtn =
        navbar.querySelector('#evNavbarMobileDropdownBtn');

    const mobileDropdown =
        mobileDropdownBtn
            ? mobileDropdownBtn.closest('.ev-navbar__dropdown')
            : null;

    /* =====================================================
       DESKTOP DROPDOWN - PERBAIKAN UTAMA
       ===================================================== */

    const desktopDropdown = document.getElementById('evNavbarDropdown');
    const desktopDropdownBtn = document.getElementById('evNavbarDropdownBtn');
    let dropdownTimeout = null;

    if (desktopDropdown && desktopDropdownBtn) {
        // Toggle dropdown saat diklik (untuk touch device / fallback)
        desktopDropdownBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            if (window.innerWidth <= 900) {
                return;
            }

            desktopDropdown.classList.toggle('active');
        });

        // Hover dengan delay untuk desktop
        desktopDropdown.addEventListener('mouseenter', function() {
            clearTimeout(dropdownTimeout);
            if (window.innerWidth > 900) {
                desktopDropdown.classList.add('active');
            }
        });

        desktopDropdown.addEventListener('mouseleave', function() {
            if (window.innerWidth > 900) {
                // Delay 300ms sebelum menutup
                dropdownTimeout = setTimeout(function() {
                    desktopDropdown.classList.remove('active');
                }, 300);
            }
        });

        // Mencegah close saat hover di dalam dropdown content
        const dropdownContent = desktopDropdown.querySelector('.ev-navbar__dropdown-content');
        if (dropdownContent) {
            dropdownContent.addEventListener('mouseenter', function() {
                clearTimeout(dropdownTimeout);
                desktopDropdown.classList.add('active');
            });

            dropdownContent.addEventListener('mouseleave', function() {
                dropdownTimeout = setTimeout(function() {
                    desktopDropdown.classList.remove('active');
                }, 300);
            });
        }

        // Tutup dropdown saat klik di luar
        document.addEventListener('click', function(e) {
            if (window.innerWidth > 900) {
                if (!desktopDropdown.contains(e.target)) {
                    desktopDropdown.classList.remove('active');
                }
            }
        });
    }


    /* =====================================================
       MOBILE MENU
       ===================================================== */

    if (menuToggle && mobileNavLinks) {

        menuToggle.addEventListener('click', function (e) {

            e.stopPropagation();

            const isActive =
                mobileNavLinks.classList.toggle('active');

            menuToggle.setAttribute(
                'aria-expanded',
                isActive ? 'true' : 'false'
            );

            menuToggle.textContent =
                isActive ? '✕' : '☰';
        });
    }


    /* =====================================================
       MOBILE DROPDOWN
       ===================================================== */

    if (mobileDropdownBtn && mobileDropdown) {

        mobileDropdownBtn.addEventListener(
            'click',
            function (e) {

                e.preventDefault();
                e.stopPropagation();

                mobileDropdown.classList.toggle('active');
            }
        );
    }


    /* =====================================================
       CLOSE MOBILE MENU
       ===================================================== */

    if (mobileNavLinks) {

        mobileNavLinks
            .querySelectorAll('a')
            .forEach(function (link) {

                link.addEventListener(
                    'click',
                    function () {

                        if (window.innerWidth <= 900) {

                            mobileNavLinks
                                .classList
                                .remove('active');

                            if (menuToggle) {

                                menuToggle.textContent = '☰';

                                menuToggle.setAttribute(
                                    'aria-expanded',
                                    'false'
                                );
                            }
                        }
                    }
                );
            });
    }


    /* =====================================================
       CLICK OUTSIDE
       ===================================================== */

    document.addEventListener(
        'click',
        function (e) {

            if (window.innerWidth <= 900) {

                const clickedInside =
                    e.target.closest('.ev-navbar');

                if (!clickedInside && mobileNavLinks) {

                    mobileNavLinks
                        .classList
                        .remove('active');

                    if (menuToggle) {

                        menuToggle.textContent = '☰';

                        menuToggle.setAttribute(
                            'aria-expanded',
                            'false'
                        );
                    }
                }
            }
        }
    );


    /* =====================================================
       SEARCH
       ===================================================== */

    let searchTimeout = null;
    let isSearching = false;


    function setupSearch(input, results) {

        if (!input || !results) {
            return;
        }

        input.addEventListener(
            'input',
            function () {

                const query =
                    this.value.trim();

                clearTimeout(searchTimeout);

                if (query.length < 2) {

                    results
                        .classList
                        .remove('active');

                    return;
                }

                searchTimeout = setTimeout(
                    function () {

                        performNavSearch(
                            query,
                            results
                        );

                    },
                    300
                );
            }
        );


        input.addEventListener(
            'keydown',
            function (e) {

                if (e.key === 'Escape') {

                    results
                        .classList
                        .remove('active');

                    this.blur();
                }
            }
        );
    }


    setupSearch(
        searchInput,
        searchResults
    );

    setupSearch(
        searchInputMobile,
        searchResultsMobile
    );


    /* =====================================================
       SEARCH REQUEST
       ===================================================== */

    function performNavSearch(query, results) {

        if (isSearching) {
            return;
        }

        isSearching = true;

        const compareIds =
            @json(session('compare', []));


        fetch(
            '{{ route("landing.search") }}?q=' +
            encodeURIComponent(query)
        )

        .then(function (response) {

            if (!response.ok) {
                throw new Error(
                    'Network response was not ok'
                );
            }

            return response.json();
        })

        .then(function (data) {

            results.innerHTML = '';


            if (!data || data.length === 0) {

                results.innerHTML =
                    '<div class="ev-navbar__search-empty">' +
                    'Tidak ada hasil ditemukan' +
                    '</div>';

            } else {

                data.forEach(function (model) {

                    const isInCompare =
                        compareIds.includes(model.id);

                    const div =
                        document.createElement('div');

                    div.className =
                        'ev-navbar__search-item';


                    const safeName =
                        String(model.name || '')
                        .replace(/'/g, "\\'");

                    const safeBrand =
                        String(model.brand || '')
                        .replace(/'/g, "\\'");


                    div.innerHTML = `

                        <img
                            src="${model.url_photo || ''}"
                            alt="${model.name || ''}"
                            onerror="this.style.display='none'"
                        >

                        <div class="ev-navbar__search-info">

                            <div class="ev-navbar__search-name">
                                ${model.name || '-'}
                            </div>

                            <div class="ev-navbar__search-brand">
                                ${model.brand || ''}
                                ${model.type ? ' · ' + model.type : ''}
                            </div>

                        </div>

                        <div class="ev-navbar__search-actions">

                            <a
                                href="{{ route('compare.detail', '') }}/${model.id}"
                                class="ev-navbar__search-btn ev-navbar__search-btn--detail"
                            >
                                Detail
                            </a>

                            <button
                                type="button"
                                class="ev-navbar__search-btn ev-navbar__search-btn--compare"
                                onclick="evNavbarAddToCompare(${model.id}, '${safeName}', '${safeBrand}')"
                                ${isInCompare ? 'disabled' : ''}
                            >
                                ${isInCompare ? '✓' : '+'}
                            </button>

                        </div>
                    `;

                    results.appendChild(div);
                });
            }

            results.classList.add('active');

        })

        .catch(function (error) {

            console.error(
                'Navbar search error:',
                error
            );

        })

        .finally(function () {

            isSearching = false;

        });
    }


    /* =====================================================
       CLOSE SEARCH
       ===================================================== */

    document.addEventListener(
        'click',
        function (e) {

            if (!e.target.closest('.ev-navbar__search')) {

                if (searchResults) {
                    searchResults
                        .classList
                        .remove('active');
                }

                if (searchResultsMobile) {
                    searchResultsMobile
                        .classList
                        .remove('active');
                }
            }
        }
    );


    /* =====================================================
       ADD TO COMPARE
       ===================================================== */

    window.evNavbarAddToCompare =
        function (id, name, brand) {

            const compareIds =
                @json(session('compare', []));


            if (compareIds.includes(id)) {

                showNavToast(
                    'Kendaraan sudah ada di daftar perbandingan.',
                    'warning'
                );

                return;
            }


            if (compareIds.length >= 4) {

                showNavToast(
                    'Maksimal 4 kendaraan dapat dibandingkan.',
                    'error'
                );

                return;
            }


            fetch(
                '{{ route("landing.add") }}',
                {
                    method: 'POST',

                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN':
                            '{{ csrf_token() }}'
                    },

                    body: JSON.stringify({
                        id: id
                    })
                }
            )

            .then(function (response) {
                return response.json();
            })

            .then(function (data) {

                if (data.success) {

                    showNavToast(
                        data.message ||
                        'Kendaraan berhasil ditambahkan.',
                        'success'
                    );

                    updateCompareBadge(
                        data.count
                    );

                    if (searchResults) {
                        searchResults
                            .classList
                            .remove('active');
                    }

                    if (searchResultsMobile) {
                        searchResultsMobile
                            .classList
                            .remove('active');
                    }

                    if (searchInput) {
                        searchInput.value = '';
                    }

                    if (searchInputMobile) {
                        searchInputMobile.value = '';
                    }

                } else {

                    showNavToast(
                        data.message ||
                        'Gagal menambahkan kendaraan.',
                        'error'
                    );
                }
            })

            .catch(function (error) {

                console.error(
                    'Compare error:',
                    error
                );

                showNavToast(
                    'Terjadi kesalahan. Silakan coba lagi.',
                    'error'
                );
            });
        };


    /* =====================================================
       UPDATE BADGE
       ===================================================== */

    function updateCompareBadge(count) {

        const badge =
            navbar.querySelector(
                '#evNavbarCompareBadge'
            );

        if (!badge) {
            return;
        }

        badge.textContent = count;

        badge.style.display =
            count > 0 ? 'flex' : 'none';
    }


    /* =====================================================
       TOAST
       ===================================================== */

    function showNavToast(
        message,
        type = 'success'
    ) {

        let toast =
            document.querySelector(
                '.ev-navbar__toast'
            );


        if (!toast) {

            toast =
                document.createElement('div');

            toast.className =
                'ev-navbar__toast';

            document.body.appendChild(toast);
        }


        toast.textContent = message;

        toast.className =
            'ev-navbar__toast ' + type;


        void toast.offsetWidth;


        toast.classList.add('show');


        clearTimeout(
            toast._timeout
        );


        toast._timeout =
            setTimeout(
                function () {

                    toast.classList.remove(
                        'show'
                    );

                },
                3000
            );
    }


    /* =====================================================
       RESIZE
       ===================================================== */

    window.addEventListener(
        'resize',
        function () {

            if (window.innerWidth > 900) {

                if (mobileNavLinks) {

                    mobileNavLinks
                        .classList
                        .remove('active');
                }

                if (mobileDropdown) {

                    mobileDropdown
                        .classList
                        .remove('active');
                }

                if (menuToggle) {

                    menuToggle.textContent = '☰';

                    menuToggle.setAttribute(
                        'aria-expanded',
                        'false'
                    );
                }
            }
        }
    );

});
</script>
