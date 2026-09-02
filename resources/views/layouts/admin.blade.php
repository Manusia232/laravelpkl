<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fleet Admin')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: #f3f6f9;
            color: #1a2332;
            line-height: 1.6;
        }

        .shell {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .rail {
            width: 260px;
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            padding: 24px 16px;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .rail-mark {
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid #e2e8f0;
        }

        .rail-mark .name {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            display: block;
        }

        .rail-mark .sub {
            font-size: 13px;
            color: #64748b;
        }

        .rail-group-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #94a3b8;
            margin: 20px 0 10px 0;
            padding: 0 12px;
        }

        .rail nav {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .rail .item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 8px;
            color: #334155;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .rail .item svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex-shrink: 0;
        }

        .rail .item:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        .rail .item.active {
            background: #eef2ff;
            color: #4f46e5;
        }

        .rail-foot {
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #94a3b8;
        }

        /* Main Content */
        .main {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            background: white;
            padding: 20px 32px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .topbar h1 {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
        }

        .crumb {
            font-size: 14px;
            color: #64748b;
        }

        .crumb code {
            background: #f1f5f9;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 13px;
        }

        .who {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }

        .role {
            background: #eef2ff;
            color: #4f46e5;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .shell {
                flex-direction: column;
            }

            .rail {
                width: 100%;
                height: auto;
                position: static;
                padding: 16px;
            }

            .topbar {
                padding: 16px;
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="shell">

    <aside class="rail">
        <div class="rail-mark">
            <span class="name">Halaman Admin</span>
            <span class="sub">eversus</span>
        </div>
        <span class="rail-group-label">Ringkasan</span>
        <nav>
            <a class="item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
                Dashboard
            </a>
        </nav>
        <span class="rail-group-label">Data Kendaraan</span>
        <nav>
            <a class="item {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}" href="{{ route('admin.brands.index') }}">
                <svg viewBox="0 0 24 24"><path d="M20 12l-8 8-9-9V3h8l9 9z"/><circle cx="7.5" cy="7.5" r="1.2"/></svg>
                Kelola Brand
            </a>
            <a class="item {{ request()->routeIs('admin.types.*') ? 'active' : '' }}" href="{{ route('admin.types.index') }}">
                <svg viewBox="0 0 24 24"><path d="M12 2 2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                Kelola Tipe
            </a>
            <a class="item {{ request()->routeIs('admin.vehicles.*') ? 'active' : '' }}" href="{{ route('admin.vehicles.index') }}">
                <svg viewBox="0 0 24 24"><path d="M3 13l1.5-4.5A2 2 0 0 1 6.4 7h11.2a2 2 0 0 1 1.9 1.5L21 13"/><rect x="2" y="13" width="20" height="5" rx="1"/><circle cx="7" cy="18.5" r="1.6"/><circle cx="17" cy="18.5" r="1.6"/></svg>
                Kelola Kendaraan
            </a>
        </nav>
        <span class="rail-group-label">Pengguna</span>
        <nav>
            <a class="item" href="#">
                <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="3.6"/><path d="M4.5 20c1.4-3.6 4.4-5.4 7.5-5.4s6.1 1.8 7.5 5.4"/></svg>
                Kelola User
            </a>
            <a class="item" href="#">
                <svg viewBox="0 0 24 24"><path d="M4 4h16v11H8l-4 4V4z"/></svg>
                Komentar & Keluhan
            </a>
        </nav>
        <div class="rail-foot">v0.1 — desain statis</div>
    </aside>

    <div class="main">
        <header class="topbar">
            <div>
                <h1>@yield('title', 'Dashboard')</h1>
                <div class="crumb">@yield('subtitle', '')</div>
            </div>
            <div class="who">
                {{ Auth::user()->name ?? 'Administrator' }}
                <span class="role">{{ Auth::user()->role ?? 'Admin' }}</span>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   style="color:#64748b;text-decoration:none;font-size:14px;font-weight:500;margin-left:8px;">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            </div>
        </header>

        @yield('content')
    </div>
</div>

@stack('scripts')
</body>
</html>
