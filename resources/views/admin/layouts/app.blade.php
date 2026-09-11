<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Curves & Tees Admin')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/curves-logo.png') }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #f8fafc; color: #1f2937; }
        a { color: inherit; }

        /* ---------- Shell ---------- */
        .layout { display: flex; min-height: 100vh; }
        .sidebar {
            width: 260px; background: linear-gradient(180deg, #181513 0%, #100e0d 100%);
            color: #a39990; flex-shrink: 0; display: flex; flex-direction: column;
            position: sticky; top: 0; height: 100vh;
            border-right: 1px solid rgba(197, 139, 43, 0.2);
            box-shadow: 2px 0 16px rgba(0,0,0,0.15);
        }
        .sidebar-brand-card {
            padding: 16px; border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .sidebar-brand-box {
            background: #ffffff; padding: 10px 14px; border-radius: 12px;
            border: 1.5px solid rgba(197, 139, 43, 0.45); display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 14px rgba(0,0,0,0.3);
        }
        .sidebar-brand-box img {
            max-width: 100%; height: 36px; object-fit: contain; display: block;
        }
        .sidebar-brand-badge {
            font-size: 10.5px; text-transform: uppercase; letter-spacing: 1.6px;
            color: #c58b2b; font-weight: 800; text-align: center; margin-top: 8px;
        }
        .sidebar nav { flex: 1; padding: 14px 12px; overflow-y: auto; }
        .sidebar nav a {
            display: block; position: relative; padding: 11px 16px; color: #b8aea5;
            text-decoration: none; font-size: 13.5px; font-weight: 500; border-radius: 10px;
            margin-bottom: 4px; transition: all .15s ease;
        }
        .sidebar nav a::before {
            content: ""; position: absolute; left: 0; top: 50%; transform: translateY(-50%);
            width: 4px; height: 0; border-radius: 4px; background: #c58b2b;
            transition: height .15s ease;
        }
        .sidebar nav a:hover { background: rgba(255,255,255,0.06); color: #fff; }
        .sidebar nav a.active {
            background: rgba(197, 139, 43, 0.18); color: #f5d496; font-weight: 700;
        }
        .sidebar nav a.active::before { height: 60%; }
        .sidebar .sidebar-foot {
            padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.08); font-size: 13px;
        }
        .sidebar .sidebar-foot .who { color: #d1d5db; margin-bottom: 10px; }
        .sidebar .sidebar-foot .who strong { color: #fff; }
        .main { flex: 1; min-width: 0; display: flex; flex-direction: column; }
        .topbar {
            background: #fff; padding: 12px 28px; border-bottom: 1px solid #e5e7eb;
            display: flex; justify-content: space-between; align-items: center;
            position: sticky; top: 0; z-index: 20; box-shadow: 0 1px 4px rgba(0,0,0,0.03);
        }
        .topbar-brand-link {
            display: flex; align-items: center; gap: 14px; text-decoration: none; color: inherit;
        }
        .topbar-logo-badge {
            background: #ffffff; padding: 4px 10px; border-radius: 10px;
            border: 1.5px solid rgba(197, 139, 43, 0.4);
            box-shadow: 0 2px 6px rgba(0,0,0,0.06); display: flex; align-items: center; justify-content: center;
        }
        .topbar-logo-badge img {
            height: 28px; width: auto; object-fit: contain; display: block;
        }
        .topbar h1 { font-size: 19px; font-weight: 800; letter-spacing: -0.3px; color: #181513; margin: 0; }
        .topbar .crumb { font-size: 11px; color: #c58b2b; font-weight: 800; text-transform: uppercase; letter-spacing: .9px; }
        .content { padding: 28px; flex: 1; }

        /* ---------- Page head / toolbar ---------- */
        .page-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px; }
        .page-title { font-size: 18px; font-weight: 700; letter-spacing: -0.3px; color: #181513; }
        .toolbar { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
        .search-input {
            padding: 9px 14px; border: 1px solid #d1d5db; border-radius: 10px; font-size: 14px;
            background: #fff; min-width: 180px; transition: border-color .15s ease, box-shadow .15s ease;
        }
        .search-input:focus { outline: none; border-color: #c58b2b; box-shadow: 0 0 0 3px rgba(197, 139, 43, 0.22); }

        /* ---------- Cards & stats ---------- */
        .card {
            background: #fff; border-radius: 16px; border: 1px solid #e5e7eb; padding: 22px;
            margin-bottom: 20px; box-shadow: 0 1px 3px rgba(15,23,42,.05), 0 1px 2px rgba(15,23,42,.04);
        }
        .card h3 { font-size: 16px; font-weight: 700; color: #111827; }
        .grid { display: grid; gap: 16px; }
        .grid-4 { display: grid; gap: 16px; grid-template-columns: repeat(4, 1fr); }
        .grid-3 { display: grid; gap: 16px; grid-template-columns: repeat(3, 1fr); }
        .grid-2 { display: grid; gap: 16px; grid-template-columns: repeat(2, 1fr); }
        .grid-5 { display: grid; gap: 14px; grid-template-columns: repeat(5, 1fr); }

        /* Modern Dashboard Stat Cards */
        .stat-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #e5e7eb;
            padding: 20px 22px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            border-color: #cbd5e1;
        }
        .stat-card .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .stat-card .stat-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            background: #f8fafc;
        }
        .stat-card .stat-label {
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        .stat-card .stat-value {
            font-size: 30px;
            font-weight: 800;
            color: #181513;
            line-height: 1.1;
            letter-spacing: -0.5px;
            margin: 4px 0 8px 0;
        }
        .stat-card .stat-meta {
            font-size: 12px;
            color: #64748b;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .stat {
            padding: 20px; border-radius: 16px; color: #fff; position: relative; overflow: hidden;
            box-shadow: 0 1px 3px rgba(15,23,42,.12), 0 4px 10px rgba(15,23,42,.08);
            transition: transform .15s ease, box-shadow .15s ease;
        }
        .stat:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(15,23,42,.16); }
        .stat::after {
            content: ""; position: absolute; right: -28px; top: -28px; width: 96px; height: 96px;
            border-radius: 50%; background: rgba(255,255,255,0.14);
        }
        .stat .value { font-size: 27px; font-weight: 800; letter-spacing: -0.5px; }
        .stat .label { font-size: 12.5px; opacity: .92; margin-top: 2px; font-weight: 600; letter-spacing: .2px; }

        /* ---------- Tables ---------- */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 12px; overflow: hidden; }
        th, td { padding: 13px 16px; text-align: left; border-bottom: 1px solid #eef0f3; font-size: 14px; }
        th { background: #faf7f2; font-weight: 700; color: #786f66; text-transform: uppercase; font-size: 11.5px; letter-spacing: .5px; border-bottom: 2px solid #ecdcc8; }
        tbody tr { transition: background .12s ease; }
        tbody tr:hover { background: #fdfbf7; }
        tbody tr:last-child td { border-bottom: none; }

        /* ---------- Buttons ---------- */
        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 6px;
            padding: 9px 16px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer;
            border: none; text-decoration: none; transition: background .15s ease, transform .1s ease, box-shadow .15s ease, border-color .15s ease;
        }
        .btn:active { transform: translateY(1px); }
        .btn-primary { background: #181513; color: #f5d496; border: 1px solid rgba(197, 139, 43, 0.45); box-shadow: 0 2px 6px rgba(0,0,0,.15); }
        .btn-primary:hover { background: #c58b2b; color: #fff; border-color: #c58b2b; box-shadow: 0 4px 12px rgba(197,139,43,0.3); }
        .btn-gold { background: linear-gradient(135deg, #d9a044 0%, #c58b2b 100%); color: #fff; font-weight: 700; border: 1px solid #c58b2b; box-shadow: 0 2px 8px rgba(197,139,43,0.3); }
        .btn-gold:hover { background: #a8721c; color: #fff; border-color: #a8721c; }
        .btn-secondary { background: #f5f2ed; color: #374151; border: 1px solid #e2dad0; }
        .btn-secondary:hover { background: #ede5da; border-color: #c58b2b; color: #181513; }
        .btn-danger { background: #ef4444; color: #fff; }
        .btn-danger:hover { background: #dc2626; }
        .btn-sm { padding: 6px 12px; font-size: 12.5px; border-radius: 8px; }

        /* ---------- Forms ---------- */
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 13.5px; font-weight: 600; margin-bottom: 7px; color: #374151; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 10px; font-size: 14px;
            background: #fff; color: #1f2937; transition: border-color .15s ease, box-shadow .15s ease;
        }
        .form-group textarea { min-height: 110px; resize: vertical; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
            outline: none; border-color: #c58b2b; box-shadow: 0 0 0 3px rgba(197, 139, 43, 0.22);
        }
        .form-group .hint { font-size: 12.5px; color: #9ca3af; margin-top: 6px; }

        /* ---------- Badges ---------- */
        .badge { display: inline-flex; align-items: center; padding: 4px 11px; border-radius: 9999px; font-size: 12px; font-weight: 700; }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        .badge-gold { background: #fdf5e6; color: #9c6c1b; border: 1px solid #f6deb3; }
        .badge-obsidian { background: #181513; color: #f5d496; border: 1px solid rgba(197, 139, 43, 0.4); }
        .badge-danger { background: #fee2e2; color: #991b1b; }
        .badge-info { background: #dbeafe; color: #1e40af; }
        .badge-gray { background: #f3f4f6; color: #374151; }

        /* ---------- Alerts ---------- */
        .alert { padding: 13px 16px; border-radius: 12px; margin-bottom: 18px; font-size: 14px; display: flex; gap: 8px; align-items: center; }
        .alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }

        /* ---------- Misc ---------- */
        .muted { color: #6b7280; font-size: 13px; }
        .img-thumb { width: 48px; height: 48px; object-fit: cover; border-radius: 10px; border: 1px solid #e5e7eb; background: #f9fafb; }
        .actions { display: flex; gap: 6px; }
        form.inline { display: inline; }
        .pagination { margin-top: 20px; }
        .pagination nav div:first-child { margin-bottom: 10px; font-size: 13px; color: #6b7280; }
        .pagination nav { display: flex; justify-content: space-between; flex-wrap: wrap; }
        .pagination a, .pagination span[aria-current] { display: inline-flex; align-items: center; padding: 7px 14px; border-radius: 9px; font-size: 13.5px; font-weight: 600; }
        .pagination a { background: #fff; border: 1px solid #e5e7eb; color: #374151; text-decoration: none; margin: 0 2px; transition: all .12s ease; }
        .pagination a:hover { border-color: #c58b2b; color: #c58b2b; }
        .pagination span[aria-current] { background: #181513; color: #f5d496; margin: 0 2px; border: 1px solid #c58b2b; }
        .text-right { text-align: right; }
        .mt-0 { margin-top: 0; }
        .mt-2 { margin-top: 8px; }
        .mb-2 { margin-bottom: 8px; }
        .flex-between { display: flex; justify-content: space-between; align-items: center; }

        .admin-mobile-toggle {
            display: none; align-items: center; justify-content: center;
            width: 38px; height: 38px; border-radius: 9px;
            background: #f5f2ed; border: 1.5px solid rgba(197, 139, 43, 0.35);
            color: #181513; cursor: pointer; transition: all .15s ease;
        }
        .admin-mobile-toggle:hover { background: #ede5da; border-color: #c58b2b; }

        .admin-drawer-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.65);
            backdrop-filter: blur(4px); z-index: 999; opacity: 0; visibility: hidden;
            transition: all 0.3s ease;
        }
        .admin-drawer-overlay.open { opacity: 1; visibility: visible; }
        .admin-drawer-panel {
            position: fixed; top: 0; left: -320px; width: 280px; height: 100vh;
            background: linear-gradient(180deg, #181513 0%, #100e0d 100%);
            color: #a39990; z-index: 1000; display: flex; flex-direction: column;
            box-shadow: 10px 0 30px rgba(0,0,0,0.4);
            transition: left 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .admin-drawer-overlay.open .admin-drawer-panel { left: 0; }

        @media (max-width: 992px) {
            .sidebar { display: none; }
            .admin-mobile-toggle { display: inline-flex; }
            .topbar { padding: 12px 18px; }
            .content { padding: 18px 16px; }
            .grid-5 { grid-template-columns: repeat(2, 1fr); }
            .grid-4 { grid-template-columns: repeat(2, 1fr); }
            .grid-3 { grid-template-columns: 1fr; }
        }

        @media (max-width: 640px) {
            .topbar {
                padding: 10px 14px;
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }
            .topbar-header-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
            }
            .topbar-actions-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
                padding-top: 8px;
                border-top: 1px solid #f3f4f6;
            }
            .grid-5, .grid-4, .grid-3, .grid-2 {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .stat-card {
                padding: 16px 18px;
            }
            .page-head {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }
            .toolbar {
                flex-direction: column;
                align-items: stretch;
                width: 100%;
            }
            .search-input {
                width: 100%;
                min-width: 100%;
            }
            .table-wrap table {
                min-width: 580px;
            }
            .card {
                padding: 16px;
                border-radius: 12px;
            }
        }
    </style>
</head>
<body>
<div class="layout">
    <!-- Desktop Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand-card">
            <a href="{{ route('admin.dashboard') }}" style="text-decoration: none; display: block;">
                <div class="sidebar-brand-box">
                    <img src="{{ asset('images/curves-logo.png') }}" alt="Curves & Tees">
                </div>
            </a>
            <div class="sidebar-brand-badge">Boutique Administration</div>
        </div>
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">Orders</a>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">Clothing Items</a>
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">Collections</a>
            <a href="{{ route('admin.customers.index') }}" class="{{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">Customers</a>

            @if(auth()->user()->hasFullAdminAccess())
                <div style="margin: 14px 16px 4px; font-size: 10.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #78716c;">Store Administration</div>
                <a href="{{ route('admin.hero.index') }}" class="{{ request()->routeIs('admin.hero.*') ? 'active' : '' }}">Hero & Banners</a>
                <a href="{{ route('admin.leads.index') }}" class="{{ request()->routeIs('admin.leads.*') ? 'active' : '' }}">Leads & Campaigns</a>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Admin Users</a>
            @endif

            <div style="margin: 16px 0; border-top: 1px solid rgba(255,255,255,0.08);"></div>
            <a href="{{ route('store.index') }}" target="_blank" style="background: rgba(197, 139, 43, 0.16); color: #f5d496; font-weight: 700; border: 1px solid rgba(197,139,43,0.35);">
                🌐 View Online Store ↗
            </a>
        </nav>
        <div class="sidebar-foot">
            <div class="who">
                <div>Signed in as <strong>{{ auth()->user()->name }}</strong></div>
                <div style="margin-top: 5px;">
                    <span class="badge {{ auth()->user()->hasFullAdminAccess() ? 'badge-gold' : 'badge-info' }}" style="font-size: 11px;">
                        {{ auth()->user()->role_display_name }}
                    </span>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm" style="width:100%; margin-top: 8px;">Logout</button>
            </form>
        </div>
    </aside>

    <!-- Mobile Slide-In Navigation Drawer -->
    <div class="admin-drawer-overlay" id="adminDrawerOverlay" onclick="toggleAdminDrawer(false)">
        <div class="admin-drawer-panel" onclick="event.stopPropagation()">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid rgba(255,255,255,0.08);">
                <div style="background: #ffffff; padding: 6px 12px; border-radius: 10px; border: 1.5px solid #c58b2b;">
                    <img src="{{ asset('images/curves-logo.png') }}" alt="Curves & Tees" style="height: 26px; object-fit: contain;">
                </div>
                <button type="button" onclick="toggleAdminDrawer(false)" style="background: none; border: none; color: #a39990; font-size: 28px; cursor: pointer; line-height: 1;">&times;</button>
            </div>
            <div class="sidebar-brand-badge" style="padding: 10px 20px 4px 20px; text-align: left;">Boutique Administration</div>
            <nav style="padding: 10px 14px; overflow-y: auto; flex: 1;">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">📊 Dashboard</a>
                <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">🛍️ Orders</a>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">👗 Clothing Items</a>
                <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">✨ Collections</a>
                <a href="{{ route('admin.customers.index') }}" class="{{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">👥 Customers</a>

                @if(auth()->user()->hasFullAdminAccess())
                    <div style="margin: 14px 10px 4px; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #78716c;">Store Administration</div>
                    <a href="{{ route('admin.hero.index') }}" class="{{ request()->routeIs('admin.hero.*') ? 'active' : '' }}">🎬 Hero & Banners</a>
                    <a href="{{ route('admin.leads.index') }}" class="{{ request()->routeIs('admin.leads.*') ? 'active' : '' }}">💬 Leads & Campaigns</a>
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">🛡️ Admin Users</a>
                @endif

                <div style="margin: 14px 0; border-top: 1px solid rgba(255,255,255,0.08);"></div>
                <a href="{{ route('store.index') }}" target="_blank" style="background: rgba(197, 139, 43, 0.18); color: #f5d496; font-weight: 700; border: 1px solid rgba(197,139,43,0.35);">
                    🌐 View Online Store ↗
                </a>
            </nav>
            <div style="padding: 16px 20px; border-top: 1px solid rgba(255,255,255,0.08);">
                <div style="color: #d1d5db; font-size: 13px; margin-bottom: 4px;">Signed in as <strong>{{ auth()->user()->name }}</strong></div>
                <div style="margin-bottom: 10px;">
                    <span class="badge {{ auth()->user()->hasFullAdminAccess() ? 'badge-gold' : 'badge-info' }}" style="font-size: 11px;">
                        {{ auth()->user()->role_display_name }}
                    </span>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm" style="width: 100%;">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <div class="main">
        <div class="topbar">
            <div class="topbar-header-row">
                <div class="topbar-brand-link">
                    <button type="button" class="admin-mobile-toggle" onclick="toggleAdminDrawer(true)" aria-label="Open Navigation Menu">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                    <a href="{{ route('admin.dashboard') }}" title="Curves & Tees Dashboard" style="display: flex; text-decoration: none;">
                        <div class="topbar-logo-badge">
                            <img src="{{ asset('images/curves-logo.png') }}" alt="Curves & Tees Logo">
                        </div>
                    </a>
                    <div>
                        <div class="crumb">Curves & Tees • Boutique Admin</div>
                        <h1>@yield('title', 'Dashboard')</h1>
                    </div>
                </div>
            </div>
            <div class="topbar-actions-row">
                <span class="badge badge-gold">{{ now()->format('M d, Y') }}</span>
                <a href="{{ route('store.index') }}" target="_blank" class="btn btn-sm btn-primary">Visit Web Store ↗</a>
            </div>
        </div>
        <div class="content">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif
            @yield('content')

            <footer style="margin-top: 40px; padding: 20px 0 10px 0; border-top: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; font-size: 12.5px; color: #6b7280;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <img src="{{ asset('images/curves-logo.png') }}" alt="Curves & Tees" style="height: 20px; object-fit: contain;">
                    <span>Curves & Tees Ghana • Boutique Management & Online Catalog</span>
                </div>
                <div style="display: flex; gap: 16px; align-items: center;">
                    <span style="color: #c58b2b; font-weight: 700;">Madina Estate Showroom</span>
                    <span>Hotline: +233 57 103 8444</span>
                </div>
            </footer>
        </div>
    </div>
</div>

<script>
    function toggleAdminDrawer(open) {
        const overlay = document.getElementById('adminDrawerOverlay');
        if (overlay) {
            if (open) overlay.classList.add('open');
            else overlay.classList.remove('open');
        }
    }
    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') toggleAdminDrawer(false);
    });
</script>
</body>
</html>