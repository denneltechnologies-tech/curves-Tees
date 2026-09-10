<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Curves & Tees — Chic Fashion & Ready-to-Wear | Madina, Accra')</title>
    <meta name="description" content="Shop chic, curve-flattering ready-to-wear dresses, statement graphic tees, co-ord sets, and pants at Curves & Tees. Located in Madina Estate, Accra. Nationwide Ghana delivery.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        :root {
            --primary: #c98a58;
            --primary-dark: #a86c3d;
            --primary-light: #f6ede4;
            --accent: #25D366; /* WhatsApp Green */
            --accent-dark: #128C7E;
            --bg-body: #faf8f5;
            --bg-card: #ffffff;
            --text-main: #191614;
            --text-muted: #736c66;
            --border-color: #ede7df;
            --radius-sm: 8px;
            --radius-md: 14px;
            --radius-lg: 22px;
            --shadow-soft: 0 10px 30px rgba(0, 0, 0, 0.05);
            --shadow-hover: 0 18px 40px rgba(168, 108, 61, 0.12);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .serif {
            font-family: 'Cormorant Garamond', Georgia, serif;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button {
            font-family: inherit;
            cursor: pointer;
            border: none;
            outline: none;
        }

        /* Top Announcement Bar */
        .announcement-bar {
            background: #151311;
            color: #f5eedb;
            padding: 8px 16px;
            font-size: 12px;
            font-weight: 500;
            display: flex;
            justify-content: space-between;
            align-items: center;
            letter-spacing: 0.3px;
        }
        .announcement-bar a {
            color: #e5b88f;
            text-decoration: underline;
            font-weight: 600;
        }
        @media (max-width: 768px) {
            .announcement-bar .hide-mobile { display: none; }
            .announcement-bar { justify-content: center; text-align: center; }
        }

        /* Header / Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(12px);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }
        .navbar-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .brand-mark {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #1f1b18 0%, #3d352e 100%);
            color: #e5b88f;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px;
            font-weight: 700;
            border: 1px solid rgba(229, 184, 143, 0.3);
            box-shadow: 0 4px 14px rgba(0,0,0,0.1);
        }
        .brand-text h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
            line-height: 1.1;
            color: #191614;
        }
        .brand-text span {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--primary);
            font-weight: 700;
            display: block;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 28px;
            list-style: none;
        }
        .nav-menu a {
            font-size: 14px;
            font-weight: 600;
            color: #4a453f;
            transition: color 0.2s;
            position: relative;
        }
        .nav-menu a:hover, .nav-menu a.active {
            color: var(--primary-dark);
        }
        .nav-menu a.active::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--primary);
            border-radius: 2px;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .btn-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #f4ede5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-main);
            position: relative;
            transition: all 0.2s;
        }
        .btn-icon:hover {
            background: #e8ded2;
            transform: translateY(-2px);
        }
        .cart-badge {
            position: absolute;
            top: -3px;
            right: -3px;
            background: #b91c1c;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
        }

        .btn-whatsapp-nav {
            background: #25D366;
            color: #ffffff;
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.25);
        }
        .btn-whatsapp-nav:hover {
            background: #20ba59;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37, 211, 102, 0.35);
        }

        @media (max-width: 900px) {
            .nav-menu { display: none; }
            .btn-whatsapp-nav span { display: none; }
            .btn-whatsapp-nav { padding: 10px; border-radius: 50%; }
            .mobile-menu-toggle { display: flex !important; }
        }
        #mobileMenuOverlay.open .drawer-panel {
            left: 0 !important;
        }

        /* Cart Drawer (Slide-Over) */
        .drawer-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .drawer-overlay.open {
            opacity: 1;
            visibility: visible;
        }

        .drawer-panel {
            position: fixed;
            top: 0;
            right: -460px;
            width: 100%;
            max-width: 440px;
            height: 100vh;
            background: #ffffff;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            box-shadow: -10px 0 35px rgba(0,0,0,0.15);
            transition: right 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .drawer-overlay.open .drawer-panel {
            right: 0;
        }

        .drawer-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .drawer-header h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 24px;
            font-weight: 700;
        }
        .btn-close-drawer {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #f5f2eb;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            transition: all 0.2s;
        }
        .btn-close-drawer:hover {
            background: #e8e2d5;
            color: var(--text-main);
        }

        .drawer-body {
            flex: 1;
            overflow-y: auto;
            padding: 20px 24px;
        }

        .drawer-item {
            display: flex;
            gap: 16px;
            padding: 16px 0;
            border-bottom: 1px solid #f0eae1;
            align-items: center;
        }
        .drawer-item-img {
            width: 72px;
            height: 90px;
            border-radius: var(--radius-sm);
            object-fit: cover;
            background: #eee;
            flex-shrink: 0;
        }
        .drawer-item-info {
            flex: 1;
            min-width: 0;
        }
        .drawer-item-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .drawer-item-size {
            font-size: 12px;
            color: var(--primary-dark);
            font-weight: 600;
            background: var(--primary-light);
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            margin-bottom: 6px;
        }
        .drawer-item-price {
            font-weight: 800;
            font-size: 14px;
            color: #191614;
        }
        .drawer-qty-stepper {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
        }
        .qty-btn {
            width: 26px;
            height: 26px;
            border-radius: 6px;
            background: #f0ebe2;
            color: #1f1b18;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.15s;
        }
        .qty-btn:hover {
            background: #dfd7cb;
        }
        .qty-val {
            font-size: 13px;
            font-weight: 700;
            min-width: 18px;
            text-align: center;
        }
        .btn-remove-item {
            color: #b91c1c;
            background: transparent;
            font-size: 12px;
            padding: 4px;
            display: flex;
            align-items: center;
            margin-left: auto;
        }

        .drawer-footer {
            padding: 20px 24px;
            background: #faf8f5;
            border-top: 1px solid var(--border-color);
        }
        .drawer-summary-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 8px;
            color: var(--text-muted);
        }
        .drawer-summary-row.total {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-main);
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px dashed var(--border-color);
        }

        .btn-checkout-primary {
            width: 100%;
            padding: 14px;
            border-radius: var(--radius-sm);
            background: var(--text-main);
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 12px;
            transition: all 0.2s;
        }
        .btn-checkout-primary:hover {
            background: #000;
            transform: translateY(-2px);
        }

        .btn-checkout-whatsapp {
            width: 100%;
            padding: 14px;
            border-radius: var(--radius-sm);
            background: #25D366;
            color: #ffffff;
            font-size: 15px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 8px;
            transition: all 0.2s;
            box-shadow: 0 4px 14px rgba(37, 211, 102, 0.25);
        }
        .btn-checkout-whatsapp:hover {
            background: #1fb956;
            transform: translateY(-2px);
        }

        /* Quick View Modal */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.65);
            backdrop-filter: blur(5px);
            z-index: 1050;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .modal-overlay.open {
            opacity: 1;
            visibility: visible;
        }
        .modal-content {
            background: #ffffff;
            width: 100%;
            max-width: 820px;
            border-radius: var(--radius-md);
            overflow: hidden;
            display: grid;
            grid-template-columns: 1fr 1.1fr;
            box-shadow: 0 25px 60px rgba(0,0,0,0.25);
            position: relative;
            transform: scale(0.95);
            transition: all 0.3s ease;
        }
        .modal-overlay.open .modal-content {
            transform: scale(1);
        }
        @media (max-width: 768px) {
            .modal-content {
                grid-template-columns: 1fr;
                max-height: 85vh;
                overflow-y: auto;
            }
        }
        .modal-close-btn {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255,255,255,0.9);
            color: #191614;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* Toast notification */
        .toast-notification {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #191614;
            color: #ffffff;
            padding: 14px 22px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 2000;
            border-left: 4px solid var(--primary);
        }
        .toast-notification.show {
            transform: translateY(0);
            opacity: 1;
        }

        /* Floating WhatsApp Button */
        .floating-whatsapp {
            position: fixed;
            bottom: 24px;
            left: 24px;
            background: #25D366;
            color: #ffffff;
            padding: 12px 20px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 700;
            box-shadow: 0 8px 24px rgba(37, 211, 102, 0.35);
            z-index: 90;
            transition: all 0.25s ease;
        }
        .floating-whatsapp:hover {
            background: #1eb855;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 12px 30px rgba(37, 211, 102, 0.45);
        }

        /* Footer */
        .footer {
            background: #151311;
            color: #b0a9a1;
            padding: 60px 24px 30px;
            border-top: 1px solid #282420;
            margin-top: 80px;
        }
        .footer-container {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 40px;
            margin-bottom: 40px;
        }
        @media (max-width: 900px) {
            .footer-container { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 600px) {
            .footer-container { grid-template-columns: 1fr; }
        }
        .footer-col h4 {
            color: #f5eedb;
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px;
            margin-bottom: 18px;
        }
        .footer-col ul {
            list-style: none;
        }
        .footer-col ul li {
            margin-bottom: 10px;
        }
        .footer-col ul a {
            color: #b0a9a1;
            font-size: 14px;
            transition: color 0.2s;
        }
        .footer-col ul a:hover {
            color: #e5b88f;
        }
        .footer-bottom {
            max-width: 1280px;
            margin: 0 auto;
            padding-top: 24px;
            border-top: 1px solid rgba(255,255,255,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
        }
        /* ========================================================
           Boutique Pagination Styling & SVG Guard
           ======================================================== */
        .store-pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 48px 0 24px;
            width: 100%;
        }
        .store-pagination-nav {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ffffff;
            padding: 8px 16px;
            border-radius: 50px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 16px rgba(0,0,0,0.04);
            flex-wrap: wrap;
            justify-content: center;
        }
        .page-control {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 13.5px;
            font-weight: 700;
            color: var(--text-main);
            background: #f8f6f3;
            text-decoration: none;
            transition: all 0.2s ease;
            border: 1px solid var(--border-color);
        }
        .page-control:hover:not(.disabled) {
            background: var(--primary-light);
            color: var(--primary-dark);
            border-color: rgba(201,138,88,0.4);
            transform: translateY(-1px);
        }
        .page-control.disabled {
            opacity: 0.4;
            cursor: not-allowed;
            background: #fdfdfd;
        }
        .page-numbers {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .page-num {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0 10px;
            border-radius: 50px;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            color: var(--text-main);
            border: 1px solid transparent;
            transition: all 0.2s ease;
        }
        .page-num:hover:not(.active):not(.dots) {
            background: var(--primary-light);
            color: var(--primary-dark);
            border-color: rgba(201,138,88,0.3);
        }
        .page-num.active {
            background: #191614;
            color: #ffffff;
            border-color: #191614;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .page-num.dots {
            cursor: default;
            color: var(--text-muted);
        }
        /* Global SVG guard */
        svg {
            max-width: 100%;
            max-height: 100%;
        }
        .store-pagination svg,
        svg.w-5.h-5 {
            width: 16px !important;
            height: 16px !important;
            max-width: 16px !important;
            max-height: 16px !important;
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- Top Announcement Bar -->
    <div class="announcement-bar">
        <span>✨ Welcome to Curves & Tees — Curve-Flattering Ready-to-Wear in Madina Estate, Accra!</span>
        <span class="hide-mobile">
            Nationwide Delivery Across Ghana • <a href="https://wa.me/233571038444" target="_blank">Order Hotline: +233 57 103 8444</a>
        </span>
    </div>

    @php
        $globalCategories = \App\Models\Category::where('status', 'active')->orderBy('id')->get();
        // Remove Pants, Skirts & Denim and Accessories & Essentials from top navigation tabs to keep it clean
        $navCategories = $globalCategories->reject(function ($c) {
            $name = strtolower($c->name);
            return in_array($c->id, [4, 5])
                || str_contains($name, 'pants')
                || str_contains($name, 'denim')
                || str_contains($name, 'skirts')
                || str_contains($name, 'accessories')
                || str_contains($name, 'essentials');
        });
    @endphp

    <!-- Navigation Header -->
    <header class="navbar">
        <div class="navbar-container">
            <!-- Brand -->
            <a href="{{ route('store.index') }}" class="brand-logo" id="brandLogo">
                <div class="brand-mark">C&T</div>
                <div class="brand-text">
                    <h1>Curves & Tees</h1>
                    <span>Boutique • Madina</span>
                </div>
            </a>

            <!-- Menu Navigation -->
            <nav>
                <ul class="nav-menu">
                    <li><a href="{{ route('store.index') }}" class="{{ request()->routeIs('store.index') && !request()->has('category') ? 'active' : '' }}">All Outfits</a></li>
                    @foreach($navCategories as $navCat)
                        <li>
                            <a href="{{ route('store.index', ['category' => $navCat->id]) }}" class="{{ request('category') == $navCat->id ? 'active' : '' }}">
                                {{ $navCat->name }}
                            </a>
                        </li>
                    @endforeach
                    <li><a href="{{ route('store.index') }}#location">Visit Store</a></li>
                </ul>
            </nav>

            <!-- Actions -->
            <div class="nav-actions">
                <!-- Instagram Link -->
                <a href="https://www.instagram.com/curves_and_tees/?hl=en" target="_blank" class="btn-icon" title="Visit us on Instagram @curves_and_tees" id="instagramBtn">
                    <i data-lucide="instagram"></i>
                </a>

                <!-- WhatsApp Quick Chat -->
                <button type="button" onclick="openWhatsAppStylist(null)" class="btn-whatsapp-nav" id="whatsappNavBtn" style="border: none; cursor: pointer;">
                    <i data-lucide="message-circle"></i>
                    <span>Order on WhatsApp</span>
                </button>

                <!-- Cart Button -->
                <button class="btn-icon" id="cartOpenBtn" onclick="toggleCartDrawer(true)" title="View Cart">
                    <i data-lucide="shopping-bag"></i>
                    <span class="cart-badge" id="cartBadgeCount">0</span>
                </button>

                <!-- Mobile Menu Button -->
                <button class="btn-icon mobile-menu-toggle" id="mobileMenuBtn" onclick="toggleMobileMenu(true)" title="Open Menu" style="display: none;">
                    <i data-lucide="menu"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation Drawer -->
    <div class="drawer-overlay" id="mobileMenuOverlay" onclick="toggleMobileMenu(false)">
        <div class="drawer-panel" style="left: -320px; right: auto; max-width: 300px; transition: left 0.3s ease;" onclick="event.stopPropagation()">
            <div class="drawer-header">
                <h3>Navigation</h3>
                <button class="btn-close-drawer" onclick="toggleMobileMenu(false)">
                    <i data-lucide="x"></i>
                </button>
            </div>
            <div class="drawer-body" style="padding: 16px 20px;">
                <ul style="list-style: none; display: flex; flex-direction: column; gap: 8px;">
                    <li>
                        <a href="{{ route('store.index') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 12px 14px; border-radius: 8px; font-weight: 700; font-size: 14px; background: {{ !request('category') ? 'var(--primary-light)' : 'transparent' }}; color: {{ !request('category') ? 'var(--primary-dark)' : 'var(--text-main)' }};">
                            <span>👗 All Outfits</span>
                            <i data-lucide="chevron-right" style="width: 16px;"></i>
                        </a>
                    </li>
                    @foreach($navCategories as $navCat)
                        <li>
                            <a href="{{ route('store.index', ['category' => $navCat->id]) }}" style="display: flex; align-items: center; justify-content: space-between; padding: 12px 14px; border-radius: 8px; font-weight: 600; font-size: 14px; background: {{ request('category') == $navCat->id ? 'var(--primary-light)' : 'transparent' }}; color: {{ request('category') == $navCat->id ? 'var(--primary-dark)' : 'var(--text-main)' }};">
                                <span>{{ $navCat->name }}</span>
                                <i data-lucide="chevron-right" style="width: 16px;"></i>
                            </a>
                        </li>
                    @endforeach
                    <li style="border-top: 1px solid var(--border-color); padding-top: 10px; margin-top: 6px;">
                        <a href="{{ route('store.index') }}#location" onclick="toggleMobileMenu(false)" style="display: flex; align-items: center; gap: 10px; padding: 12px 14px; border-radius: 8px; font-weight: 600; font-size: 14px; color: var(--text-main);">
                            <i data-lucide="map-pin" style="color: var(--primary-dark); width: 18px;"></i>
                            <span>Visit Madina Showroom</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="toggleMobileMenu(false); openWhatsAppStylist(null);" style="display: flex; align-items: center; gap: 10px; padding: 12px 14px; border-radius: 8px; font-weight: 700; font-size: 14px; color: #25D366; background: #f0fdf4;">
                            <i data-lucide="message-circle" style="width: 18px;"></i>
                            <span>Chat Hotline: +233 57 103 8444</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/curves_and_tees/?hl=en" target="_blank" style="display: flex; align-items: center; gap: 10px; padding: 12px 14px; border-radius: 8px; font-weight: 700; font-size: 14px; color: #dc2743; background: #fdf2f4;">
                            <i data-lucide="instagram" style="width: 18px;"></i>
                            <span>Instagram @curves_and_tees</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Slide-Over Cart Drawer -->
    <div class="drawer-overlay" id="cartDrawerOverlay" onclick="toggleCartDrawer(false)">
        <div class="drawer-panel" onclick="event.stopPropagation()">
            <div class="drawer-header">
                <h3>Shopping Bag (<span id="drawerCount">0</span>)</h3>
                <button class="btn-close-drawer" onclick="toggleCartDrawer(false)">
                    <i data-lucide="x"></i>
                </button>
            </div>

            <div class="drawer-body" id="drawerItemsList">
                <!-- Dynamic Items Inserted via JavaScript -->
            </div>

            <div class="drawer-footer" id="drawerFooter">
                <div class="drawer-summary-row">
                    <span>Subtotal</span>
                    <span id="drawerSubtotal">GH₵ 0.00</span>
                </div>
                <div class="drawer-summary-row">
                    <span>Delivery</span>
                    <span style="color: #25D366; font-weight: 600;">Calculated at checkout</span>
                </div>
                <div class="drawer-summary-row total">
                    <span>Estimated Total</span>
                    <span id="drawerTotal">GH₵ 0.00</span>
                </div>

                <a href="{{ route('store.checkout') }}" class="btn-checkout-primary" id="drawerCheckoutBtn">
                    <i data-lucide="lock"></i>
                    <span>Proceed to Checkout</span>
                </a>

                <button class="btn-checkout-whatsapp" onclick="checkoutDirectlyViaWhatsApp()" id="drawerWhatsAppBtn">
                    <i data-lucide="message-circle"></i>
                    <span>Quick Order on WhatsApp</span>
                </button>

                <div style="background: #faf6f0; border: 1px dashed #c98a58; border-radius: 12px; padding: 12px 14px; margin-top: 14px; display: flex; flex-direction: column; gap: 6px;">
                    <div style="font-size: 12px; font-weight: 700; color: #a86c3d; display: flex; align-items: center; gap: 6px;">
                        <span>🎁</span> Save your bag & get VIP discounts
                    </div>
                    <div style="display: flex; gap: 6px;">
                        <input type="tel" id="drawerCustomerPhone" placeholder="Your WhatsApp number..." style="flex: 1; padding: 8px 12px; border-radius: 8px; border: 1px solid #d1d5db; font-size: 13px; background: #fff;">
                        <button type="button" onclick="saveCartDrawerLead()" style="background: #191614; color: #fff; padding: 8px 14px; border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer;">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick View Modal -->
    <div class="modal-overlay" id="quickViewModal" onclick="closeQuickViewModal()">
        <div class="modal-content" onclick="event.stopPropagation()">
            <button class="modal-close-btn" onclick="closeQuickViewModal()">
                <i data-lucide="x"></i>
            </button>
            <div style="background: #f6ede4; min-height: 380px;">
                <img id="modalProductImg" src="" alt="Product" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div style="padding: 32px; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <span id="modalCategory" style="font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; color: var(--primary-dark); font-weight: 700;">CATEGORY</span>
                    <h2 id="modalTitle" class="serif" style="font-size: 26px; margin: 8px 0 12px; line-height: 1.2;">Product Title</h2>
                    <div id="modalPrice" style="font-size: 22px; font-weight: 800; color: var(--text-main); margin-bottom: 16px;">GH₵ 0.00</div>
                    <p id="modalDescription" style="font-size: 14px; color: var(--text-muted); line-height: 1.6; margin-bottom: 20px;">Product description goes here.</p>

                    <!-- Size Picker -->
                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px; color: var(--text-main);">Select Size:</label>
                        <div id="modalSizesContainer" style="display: flex; flex-wrap: wrap; gap: 8px;">
                            <!-- Dynamic Size Buttons -->
                        </div>
                    </div>
                </div>

                <div>
                    <div style="display: flex; gap: 12px;">
                        <button class="btn-checkout-primary" style="margin-top: 0; flex: 1;" onclick="addCurrentModalItemToCart()">
                            <i data-lucide="shopping-bag"></i>
                            <span>Add to Bag</span>
                        </button>
                        <button type="button" id="modalWhatsAppInquiryBtn" onclick="inquireModalProductWhatsApp()" class="btn-whatsapp-nav" style="border-radius: var(--radius-sm); padding: 0 18px; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                            <i data-lucide="message-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- WhatsApp Stylist & Lead Capture Modal -->
    <div class="modal-overlay" id="whatsappLeadModal" onclick="closeWhatsAppModal()">
        <div class="modal-content" onclick="event.stopPropagation()" style="max-width: 460px; grid-template-columns: 1fr; padding: 32px 28px; border-radius: 20px;">
            <button class="modal-close-btn" onclick="closeWhatsAppModal()">
                <i data-lucide="x"></i>
            </button>
            <div style="text-align: center; margin-bottom: 20px;">
                <div style="width: 54px; height: 54px; border-radius: 50%; background: #25D366; color: #fff; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; font-size: 26px; box-shadow: 0 8px 20px rgba(37,211,102,0.35);">
                    💬
                </div>
                <h3 class="serif" style="font-size: 24px; color: #191614; margin-bottom: 6px;">Order & Chat on WhatsApp</h3>
                <p style="font-size: 13.5px; color: #736c66; line-height: 1.5;">Specify your outfit request and size to connect directly with our Madina boutique concierge.</p>
            </div>

            <form id="whatsappLeadForm" onsubmit="handleWhatsAppLeadSubmit(event)">
                <div style="margin-bottom: 14px; text-align: left;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #191614;">Your Full Name *</label>
                    <input type="text" id="leadNameInput" placeholder="e.g. Akosua Mensah" required style="width: 100%; padding: 11px 14px; border-radius: 10px; border: 1.5px solid #d1d5db; font-size: 14px;">
                </div>
                <div style="margin-bottom: 14px; text-align: left;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #191614;">WhatsApp Phone Number *</label>
                    <input type="tel" id="leadPhoneInput" placeholder="e.g. 054 123 4567" required style="width: 100%; padding: 11px 14px; border-radius: 10px; border: 1.5px solid #d1d5db; font-size: 14px;">
                </div>
                <div style="margin-bottom: 14px; text-align: left;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #191614;">Outfit / Item Requested *</label>
                    <input type="text" id="leadOutfitInput" placeholder="e.g. Sunkissed Ribbed Bodycon Midi Dress" required style="width: 100%; padding: 11px 14px; border-radius: 10px; border: 1.5px solid #d1d5db; font-size: 14px;">
                </div>
                <div style="margin-bottom: 14px; text-align: left;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #191614;">Size Requested *</label>
                    <select id="leadSizeInput" required style="width: 100%; padding: 11px 14px; border-radius: 10px; border: 1.5px solid #d1d5db; font-size: 14px; background: #fff; color: #191614;">
                        <option value="UK 10">UK 10 (Small / Bust 34", Waist 28")</option>
                        <option value="UK 12">UK 12 (Medium / Bust 36", Waist 30")</option>
                        <option value="UK 14" selected>UK 14 (Large / Bust 38", Waist 32")</option>
                        <option value="UK 16">UK 16 (XL / Bust 40", Waist 34")</option>
                        <option value="UK 18">UK 18 (1X / Bust 43", Waist 37")</option>
                        <option value="UK 20">UK 20 (2X / Bust 46", Waist 40")</option>
                        <option value="UK 22">UK 22 (3X / Bust 49", Waist 43")</option>
                        <option value="Free Size / Need Sizing Advice">Free Size / Need Sizing Advice</option>
                    </select>
                </div>
                <div style="margin-bottom: 18px; text-align: left;">
                    <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #191614;">Color Preference / Delivery Notes (Optional)</label>
                    <input type="text" id="leadNotesInput" placeholder="e.g. Black color, need delivery to East Legon" style="width: 100%; padding: 10px 14px; border-radius: 10px; border: 1.5px solid #d1d5db; font-size: 13.5px;">
                </div>
                <button type="submit" class="btn-checkout-primary" style="background: #25D366; color: #fff; margin-top: 0; box-shadow: 0 6px 18px rgba(37,211,102,0.35); border: none; width: 100%;">
                    <span>Continue to WhatsApp</span>
                    <span>→</span>
                </button>
                <button type="button" onclick="skipToWhatsApp()" style="width: 100%; background: none; border: none; color: #9ca3af; padding: 10px; font-size: 12.5px; cursor: pointer; text-decoration: underline; margin-top: 6px;">
                    Skip and open WhatsApp directly
                </button>
            </form>
        </div>
    </div>

    <!-- Floating WhatsApp Hotline Button -->
    <a href="javascript:void(0)" onclick="openWhatsAppStylist(null)" class="floating-whatsapp" id="floatingWhatsAppBtn">
        <i data-lucide="message-circle"></i>
        <span>Chat with us</span>
    </a>

    <!-- Toast Notification -->
    <div class="toast-notification" id="toastNotification">
        <i data-lucide="check-circle" style="color: #25D366;"></i>
        <span id="toastMessage">Item added to your bag!</span>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-col">
                <div class="brand-logo" style="margin-bottom: 16px;">
                    <div class="brand-mark" style="background: #2a2520; color: #e5b88f;">C&T</div>
                    <div class="brand-text">
                        <h1 style="color: #fff; font-size: 22px;">Curves & Tees</h1>
                        <span>Boutique • Madina Estate</span>
                    </div>
                </div>
                <p style="font-size: 14px; line-height: 1.7; margin-bottom: 20px;">
                    Accra’s premier destination for curve-flattering, ready-to-wear women’s fashion. Designed to celebrate your silhouette in effortless comfort and style.
                </p>
                <div style="display: flex; gap: 12px;">
                    <a href="https://www.instagram.com/curves_and_tees/?hl=en" target="_blank" style="width: 36px; height: 36px; border-radius: 50%; background: #2a2520; color: #e5b88f; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="instagram" style="width: 18px; height: 18px;"></i>
                    </a>
                    <a href="https://wa.me/233571038444" target="_blank" style="width: 36px; height: 36px; border-radius: 50%; background: #2a2520; color: #25D366; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="message-circle" style="width: 18px; height: 18px;"></i>
                    </a>
                    <a href="https://www.facebook.com" target="_blank" style="width: 36px; height: 36px; border-radius: 50%; background: #2a2520; color: #3b82f6; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="facebook" style="width: 18px; height: 18px;"></i>
                    </a>
                </div>
            </div>

            <div class="footer-col">
                <h4>Collections</h4>
                <ul>
                    <li><a href="{{ route('store.index') }}#dresses">Dresses & Jumpsuits</a></li>
                    <li><a href="{{ route('store.index') }}#tees">Tops & Graphic Tees</a></li>
                    <li><a href="{{ route('store.index') }}#sets">Two-Piece Sets</a></li>
                    <li><a href="{{ route('store.index') }}#pants">Pants & Denim</a></li>
                    <li><a href="{{ route('store.index') }}">New Arrivals</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Store Info</h4>
                <ul>
                    <li><span style="font-size: 14px;">📍 Madina Estate, Accra, Ghana</span></li>
                    <li><span style="font-size: 14px;">📞 +233 57 103 8444</span></li>
                    <li><span style="font-size: 14px;">⏰ Mon – Sat: 9:00 AM – 7:00 PM</span></li>
                    <li><span style="font-size: 14px;">🚚 Nationwide Ghana Delivery</span></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Admin Portal</h4>
                <p style="font-size: 13px; margin-bottom: 14px;">Boutique management and real-time order processing terminal.</p>
                <a href="{{ route('admin.login') }}" style="display: inline-flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; color: #e5b88f; border: 1px solid rgba(229,184,143,0.3); padding: 8px 16px; border-radius: 6px;">
                    <i data-lucide="shield-check" style="width: 16px; height: 16px;"></i>
                    <span>Admin Dashboard</span>
                </a>
            </div>
        </div>

        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} Curves & Tees Ghana. All rights reserved.</span>
            <span>Tasteful, curve-flattering ready-to-wear fashion.</span>
        </div>
    </footer>

    <!-- Global Store State & Cart JavaScript -->
    <script>
        // Global Cart Storage (Saved in localStorage for user convenience)
        let cart = JSON.parse(localStorage.getItem('curves_cart') || '[]');
        let currentModalProduct = null;
        let selectedModalSize = null;

        function saveCart() {
            localStorage.setItem('curves_cart', JSON.stringify(cart));
            updateCartUI();
        }

        function updateCartUI() {
            const totalCount = cart.reduce((sum, item) => sum + item.quantity, 0);
            const totalSubtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

            // Badges
            document.querySelectorAll('#cartBadgeCount, #drawerCount').forEach(el => {
                if (el) el.textContent = totalCount;
            });

            // Totals
            const subtotalEl = document.getElementById('drawerSubtotal');
            const totalEl = document.getElementById('drawerTotal');
            if (subtotalEl) subtotalEl.textContent = 'GH₵ ' + totalSubtotal.toFixed(2);
            if (totalEl) totalEl.textContent = 'GH₵ ' + totalSubtotal.toFixed(2);

            // Render Drawer List
            const listEl = document.getElementById('drawerItemsList');
            const footerEl = document.getElementById('drawerFooter');
            if (!listEl) return;

            if (cart.length === 0) {
                listEl.innerHTML = `
                    <div style="text-align: center; padding: 40px 20px; color: var(--text-muted);">
                        <i data-lucide="shopping-bag" style="width: 48px; height: 48px; margin-bottom: 12px; stroke-width: 1.5; opacity: 0.5;"></i>
                        <h4 style="font-size: 16px; font-weight: 700; color: var(--text-main); margin-bottom: 6px;">Your bag is empty</h4>
                        <p style="font-size: 13px; margin-bottom: 20px;">Explore our ready-to-wear pieces and celebrate your curves!</p>
                        <button class="btn-checkout-primary" onclick="toggleCartDrawer(false)" style="display: inline-flex; width: auto; padding: 10px 20px;">
                            Start Shopping
                        </button>
                    </div>
                `;
                if (footerEl) footerEl.style.display = 'none';
            } else {
                if (footerEl) footerEl.style.display = 'block';
                listEl.innerHTML = cart.map((item, index) => `
                    <div class="drawer-item">
                        <img src="${item.image}" alt="${item.name}" class="drawer-item-img">
                        <div class="drawer-item-info">
                            <div class="drawer-item-title">${item.name}</div>
                            ${item.size ? `<span class="drawer-item-size">Size: ${item.size}</span>` : ''}
                            <div class="drawer-item-price">GH₵ ${(item.price * item.quantity).toFixed(2)}</div>
                            <div class="drawer-qty-stepper">
                                <button class="qty-btn" onclick="changeCartQty(${index}, -1)">-</button>
                                <span class="qty-val">${item.quantity}</span>
                                <button class="qty-btn" onclick="changeCartQty(${index}, 1)">+</button>
                                <button class="btn-remove-item" onclick="removeCartItem(${index})" title="Remove item">
                                    <i data-lucide="trash-2" style="width: 15px; height: 15px;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `).join('');
            }

            lucide.createIcons();
        }

        function addToCart(product, size = null, qty = 1) {
            const defaultSize = size || (product.sizes && product.sizes.length > 0 ? product.sizes[0] : 'Standard');
            const existingIndex = cart.findIndex(item => item.id === product.id && item.size === defaultSize);

            if (existingIndex > -1) {
                cart[existingIndex].quantity += qty;
            } else {
                cart.push({
                    id: product.id,
                    name: product.name,
                    price: parseFloat(product.price),
                    image: product.image_url,
                    size: defaultSize,
                    quantity: qty
                });
            }

            saveCart();
            showToast(`Added "${product.name}" (${defaultSize}) to bag!`);
            toggleCartDrawer(true);

            // If customer phone is known, record their item addition
            const customer = getSavedCustomer();
            if (customer && customer.phone) {
                trackCustomerLead({
                    phone: customer.phone,
                    name: customer.name,
                    action_type: 'add_to_cart',
                    product_id: product.id,
                    product_name: product.name,
                    product_price: parseFloat(product.price),
                    selected_size: defaultSize
                });
            }
        }

        function changeCartQty(index, delta) {
            if (!cart[index]) return;
            cart[index].quantity += delta;
            if (cart[index].quantity <= 0) {
                cart.splice(index, 1);
            }
            saveCart();
        }

        function removeCartItem(index) {
            if (!cart[index]) return;
            cart.splice(index, 1);
            saveCart();
        }

        function toggleCartDrawer(open) {
            const overlay = document.getElementById('cartDrawerOverlay');
            if (overlay) {
                if (open) {
                    overlay.classList.add('open');
                    document.body.style.overflow = 'hidden';
                } else {
                    overlay.classList.remove('open');
                    document.body.style.overflow = '';
                }
            }
        }

        function toggleMobileMenu(open) {
            const overlay = document.getElementById('mobileMenuOverlay');
            if (overlay) {
                if (open) {
                    overlay.classList.add('open');
                    document.body.style.overflow = 'hidden';
                } else {
                    overlay.classList.remove('open');
                    document.body.style.overflow = '';
                }
            }
        }

        function showToast(message) {
            const toast = document.getElementById('toastNotification');
            const msgEl = document.getElementById('toastMessage');
            if (toast && msgEl) {
                msgEl.textContent = message;
                toast.classList.add('show');
                setTimeout(() => toast.classList.remove('show'), 3500);
            }
        }

        // Quick View Modal Handlers
        async function openQuickView(productId) {
            try {
                const res = await fetch(`/product/${productId}`, {
                    headers: { 'Accept': 'application/json' }
                });
                const product = await res.json();
                currentModalProduct = product;

                document.getElementById('modalProductImg').src = product.image_url;
                document.getElementById('modalCategory').textContent = product.category || 'COLLECTION';
                document.getElementById('modalTitle').textContent = product.name;
                document.getElementById('modalPrice').textContent = product.price_formatted;
                document.getElementById('modalDescription').textContent = product.description;
                document.getElementById('modalWhatsAppInquiry').href = product.whatsapp_inquiry_url;

                // Populate sizes
                const sizesCont = document.getElementById('modalSizesContainer');
                sizesCont.innerHTML = '';
                selectedModalSize = product.sizes && product.sizes.length > 0 ? product.sizes[0] : null;

                if (product.sizes && product.sizes.length > 0) {
                    product.sizes.forEach((s, idx) => {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.textContent = s;
                        btn.style.padding = '8px 14px';
                        btn.style.borderRadius = '6px';
                        btn.style.fontSize = '13px';
                        btn.style.fontWeight = '600';
                        btn.style.border = '1px solid var(--border-color)';
                        btn.style.background = idx === 0 ? 'var(--text-main)' : '#fff';
                        btn.style.color = idx === 0 ? '#fff' : 'var(--text-main)';
                        btn.onclick = () => {
                            selectedModalSize = s;
                            sizesCont.querySelectorAll('button').forEach(b => {
                                b.style.background = '#fff';
                                b.style.color = 'var(--text-main)';
                            });
                            btn.style.background = 'var(--text-main)';
                            btn.style.color = '#fff';
                        };
                        sizesCont.appendChild(btn);
                    });
                }

                document.getElementById('quickViewModal').classList.add('open');
                document.body.style.overflow = 'hidden';
            } catch (err) {
                console.error(err);
            }
        }

        function closeQuickViewModal() {
            const modal = document.getElementById('quickViewModal');
            if (modal) {
                modal.classList.remove('open');
                document.body.style.overflow = '';
            }
        }

        function addCurrentModalItemToCart() {
            if (!currentModalProduct) return;
            addToCart(currentModalProduct, selectedModalSize, 1);
            closeQuickViewModal();
        }

        function inquireModalProductWhatsApp() {
            if (!currentModalProduct) return;
            const details = {
                id: currentModalProduct.id,
                name: currentModalProduct.name,
                price: currentModalProduct.price,
                size: selectedModalSize || 'Standard'
            };
            closeQuickViewModal();
            openWhatsAppStylist(details);
        }

        // ========================================================
        // Customer Lead Tracking & WhatsApp Stylist Integration
        // ========================================================
        let pendingWhatsAppAction = null;

        function getSavedCustomer() {
            return {
                name: localStorage.getItem('ct_customer_name') || '',
                phone: localStorage.getItem('ct_customer_phone') || ''
            };
        }

        function saveCustomerInfo(name, phone) {
            if (name) localStorage.setItem('ct_customer_name', name.trim());
            if (phone) localStorage.setItem('ct_customer_phone', phone.trim());
            const drawerInput = document.getElementById('drawerCustomerPhone');
            if (drawerInput && phone) drawerInput.value = phone.trim();
        }

        async function trackCustomerLead(data) {
            try {
                const payload = {
                    ...data,
                    _token: '{{ csrf_token() }}'
                };
                await fetch('{{ route("store.leads.track") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(payload)
                });
            } catch (err) {
                console.warn('Lead track notification:', err);
            }
        }

        function openWhatsAppLeadModal(config) {
            pendingWhatsAppAction = config;
            const saved = getSavedCustomer();
            const nameInput = document.getElementById('leadNameInput');
            const phoneInput = document.getElementById('leadPhoneInput');
            const outfitInput = document.getElementById('leadOutfitInput');
            const sizeInput = document.getElementById('leadSizeInput');
            const notesInput = document.getElementById('leadNotesInput');

            if (nameInput) nameInput.value = saved.name || '';
            if (phoneInput) phoneInput.value = saved.phone || '';

            const product = config ? config.product : null;
            if (outfitInput) {
                outfitInput.value = (product && product.name) ? product.name : 'Boutique Inquiries & Ready-to-Wear Pieces';
            }
            if (sizeInput) {
                if (product && product.size) {
                    sizeInput.value = product.size;
                } else if (!sizeInput.value) {
                    sizeInput.value = 'UK 14';
                }
            }
            if (notesInput) {
                notesInput.value = '';
            }

            const modal = document.getElementById('whatsappLeadModal');
            if (modal) {
                modal.classList.add('open');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeWhatsAppModal() {
            const modal = document.getElementById('whatsappLeadModal');
            if (modal) {
                modal.classList.remove('open');
                document.body.style.overflow = '';
            }
        }

        function handleWhatsAppLeadSubmit(e) {
            e.preventDefault();
            const name = document.getElementById('leadNameInput').value.trim();
            const phone = document.getElementById('leadPhoneInput').value.trim();
            const outfit = document.getElementById('leadOutfitInput').value.trim();
            const size = document.getElementById('leadSizeInput').value;
            const notes = document.getElementById('leadNotesInput') ? document.getElementById('leadNotesInput').value.trim() : '';

            if (!phone) {
                alert('Please enter your WhatsApp phone number.');
                return;
            }

            saveCustomerInfo(name, phone);

            const config = pendingWhatsAppAction || {};
            const product = config.product || null;

            trackCustomerLead({
                name: name,
                phone: phone,
                action_type: config.action || 'whatsapp_inquiry',
                product_id: product ? product.id : null,
                product_name: outfit || (product ? product.name : null),
                product_price: product ? product.price : null,
                selected_size: size || (product ? product.size : null),
                notes: notes,
                cart_data: config.action === 'checkout_whatsapp' ? cart : null
            });

            closeWhatsAppModal();

            if (config.action === 'checkout_whatsapp') {
                proceedWithWhatsAppCartOrder();
            } else {
                launchWhatsAppInquiry({ name, phone, outfit, size, notes }, product);
            }
        }

        function skipToWhatsApp() {
            const config = pendingWhatsAppAction || {};
            const product = config.product || null;
            const saved = getSavedCustomer();
            const outfit = document.getElementById('leadOutfitInput') ? document.getElementById('leadOutfitInput').value.trim() : '';
            const size = document.getElementById('leadSizeInput') ? document.getElementById('leadSizeInput').value : 'UK 14';
            closeWhatsAppModal();

            if (config.action === 'checkout_whatsapp') {
                proceedWithWhatsAppCartOrder();
            } else {
                launchWhatsAppInquiry({ name: saved.name, phone: saved.phone, outfit, size }, product);
            }
        }

        function openWhatsAppStylist(productDetails = null) {
            // Order on WhatsApp and Chat on WhatsApp always open the inquiry form with outfit & size
            openWhatsAppLeadModal({
                action: 'whatsapp_inquiry',
                product: productDetails
            });
        }

        function launchWhatsAppInquiry(customer, product) {
            const customerName = customer && customer.name ? customer.name : '';
            const customerPhone = customer && customer.phone ? customer.phone : '';
            const outfitName = (customer && customer.outfit) ? customer.outfit : (product && product.name ? product.name : 'Boutique Collection');
            const sizeVal = (customer && customer.size) ? customer.size : (product && product.size ? product.size : 'Standard');
            const notesVal = customer && customer.notes ? `• *Notes:* ${customer.notes}` : '';

            const lines = [
                "✨ *NEW INQUIRY / ORDER — CURVES & TEES* ✨",
                customerName ? `• *Customer Name:* ${customerName}` : null,
                customerPhone ? `• *WhatsApp Phone:* ${customerPhone}` : null,
                `• *Outfit Requested:* ${outfitName}`,
                `• *Size Requested:* ${sizeVal}`,
                notesVal || null,
                "--------------------------------",
                "Hello Curves & Tees! Could you please confirm availability and dispatch for delivery? 💖"
            ].filter(Boolean);

            const url = `https://wa.me/233571038444?text=${encodeURIComponent(lines.join('\n'))}`;
            window.open(url, '_blank');
        }

        function saveCartDrawerLead() {
            const input = document.getElementById('drawerCustomerPhone');
            const phone = input ? input.value.trim() : '';
            if (!phone) {
                alert('Please enter your WhatsApp phone number.');
                return;
            }

            saveCustomerInfo(null, phone);
            trackCustomerLead({
                phone: phone,
                action_type: 'vip_club',
                cart_data: cart,
                notes: 'Saved from cart drawer'
            });

            showToast('Phone saved! You will receive VIP styling alerts & exclusive discounts.');
        }

        // WhatsApp Direct Order from Cart Drawer
        function checkoutDirectlyViaWhatsApp() {
            if (cart.length === 0) return;

            const saved = getSavedCustomer();
            if (!saved.phone) {
                openWhatsAppLeadModal({
                    action: 'checkout_whatsapp',
                    onSuccess: () => proceedWithWhatsAppCartOrder()
                });
                return;
            }

            trackCustomerLead({
                phone: saved.phone,
                name: saved.name,
                action_type: 'whatsapp_inquiry',
                cart_data: cart,
                notes: 'Cart WhatsApp checkout'
            });

            proceedWithWhatsAppCartOrder();
        }

        function proceedWithWhatsAppCartOrder() {
            if (cart.length === 0) return;

            const saved = getSavedCustomer();
            let lines = [
                "✨ *NEW INQUIRY / ORDER — CURVES & TEES* ✨",
                saved.name ? `Customer: *${saved.name}*` : "Customer: Store Shopper",
                saved.phone ? `WhatsApp: *${saved.phone}*` : "",
                "--------------------------------"
            ].filter(Boolean);

            let subtotal = 0;
            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
                const sizeStr = item.size ? ` (Size: ${item.size})` : '';
                lines.push(`• ${item.quantity}x ${item.name}${sizeStr} — GH₵ ${itemTotal.toFixed(2)}`);
            });

            lines.push("--------------------------------");
            lines.push(`*Estimated Total:* *GH₵ ${subtotal.toFixed(2)}*`);
            lines.push("--------------------------------");
            lines.push("Please confirm availability and dispatch for delivery! 💖");

            const text = encodeURIComponent(lines.join('\n'));
            window.open(`https://wa.me/233571038444?text=${text}`, '_blank');
        }

        // Initialize icons and cart state on DOM load
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
            updateCartUI();

            const saved = getSavedCustomer();
            const drawerPhoneInput = document.getElementById('drawerCustomerPhone');
            if (drawerPhoneInput && saved.phone) {
                drawerPhoneInput.value = saved.phone;
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
