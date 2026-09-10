@extends('store.layouts.app')

@section('title', 'Curves & Tees — Ready-to-Wear Fashion & Online Catalog')

@push('styles')
<style>
    /* Hero Section */
    .hero-section {
        position: relative;
        background: linear-gradient(135deg, #1f1b18 0%, #362f27 100%);
        color: #ffffff;
        padding: 90px 24px 100px;
        overflow: hidden;
        border-bottom: 1px solid var(--border-color);
    }
    .hero-pattern {
        position: absolute;
        inset: 0;
        opacity: 0.08;
        background-image: radial-gradient(#e5b88f 1px, transparent 1px);
        background-size: 28px 28px;
    }
    .hero-container {
        max-width: 1280px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 60px;
        align-items: center;
        position: relative;
        z-index: 2;
    }
    @media (max-width: 900px) {
        .hero-container { grid-template-columns: 1fr; text-align: center; gap: 40px; }
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 16px;
        border-radius: 50px;
        background: rgba(229, 184, 143, 0.15);
        color: #e5b88f;
        border: 1px solid rgba(229, 184, 143, 0.3);
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 24px;
    }

    .hero-title {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 58px;
        line-height: 1.08;
        font-weight: 700;
        letter-spacing: -1px;
        margin-bottom: 20px;
        color: #faf6f0;
    }
    .hero-title em {
        color: #e5b88f;
        font-style: italic;
    }
    @media (max-width: 600px) {
        .hero-title { font-size: 40px; }
    }

    .hero-subtitle {
        font-size: 16px;
        line-height: 1.7;
        color: #cfc7bd;
        margin-bottom: 34px;
        max-width: 540px;
    }
    @media (max-width: 900px) {
        .hero-subtitle { margin: 0 auto 30px; }
    }

    .hero-actions {
        display: flex;
        gap: 16px;
        align-items: center;
        flex-wrap: wrap;
    }
    @media (max-width: 900px) {
        .hero-actions { justify-content: center; }
    }

    .btn-hero-primary {
        background: #e5b88f;
        color: #191614;
        padding: 16px 32px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 15px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.25s ease;
        box-shadow: 0 6px 20px rgba(229, 184, 143, 0.3);
    }
    .btn-hero-primary:hover {
        background: #f0cba7;
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(229, 184, 143, 0.4);
    }

    .btn-hero-whatsapp {
        background: rgba(255, 255, 255, 0.1);
        color: #ffffff;
        padding: 16px 30px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 15px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.25s ease;
        backdrop-filter: blur(8px);
    }
    .btn-hero-whatsapp:hover {
        background: #25D366;
        border-color: #25D366;
        color: #fff;
        transform: translateY(-3px);
    }

    .hero-visual {
        position: relative;
    }
    .hero-card-stack {
        position: relative;
        max-width: 440px;
        margin: 0 auto;
    }
    .hero-img-main {
        width: 100%;
        height: 520px;
        object-fit: cover;
        border-radius: 24px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
        border: 2px solid rgba(229, 184, 143, 0.2);
    }
    .hero-floating-tag {
        position: absolute;
        bottom: 24px;
        left: -20px;
        background: rgba(25, 22, 20, 0.92);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(229, 184, 143, 0.3);
        padding: 14px 20px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.3);
    }
    @media (max-width: 600px) {
        .hero-floating-tag { left: 10px; bottom: 10px; }
    }

    /* Trust Highlights Bar */
    .highlights-bar {
        background: #ffffff;
        border-bottom: 1px solid var(--border-color);
        padding: 24px;
    }
    .highlights-container {
        max-width: 1280px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
    }
    @media (max-width: 900px) {
        .highlights-container { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 600px) {
        .highlights-container { grid-template-columns: 1fr; text-align: center; }
    }
    .highlight-card {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    @media (max-width: 600px) {
        .highlight-card { justify-content: center; }
    }
    .highlight-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: var(--primary-light);
        color: var(--primary-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .highlight-text h5 {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-main);
    }
    .highlight-text p {
        font-size: 12px;
        color: var(--text-muted);
    }

    /* Catalog Section */
    .catalog-section {
        max-width: 1280px;
        margin: 60px auto;
        padding: 0 24px;
    }
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 36px;
        flex-wrap: wrap;
        gap: 20px;
    }
    .section-title h2 {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 38px;
        font-weight: 700;
        letter-spacing: -0.5px;
        line-height: 1.1;
    }
    .section-title p {
        font-size: 14px;
        color: var(--text-muted);
        margin-top: 6px;
    }

    /* Category Filter Pills */
    .category-pills {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 12px;
        margin-bottom: 30px;
        scrollbar-width: none;
    }
    .category-pills::-webkit-scrollbar { display: none; }
    .category-pill {
        padding: 10px 22px;
        border-radius: 50px;
        background: #ffffff;
        border: 1px solid var(--border-color);
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
        white-space: nowrap;
        transition: all 0.2s;
    }
    .category-pill:hover, .category-pill.active {
        background: #191614;
        color: #ffffff;
        border-color: #191614;
        transform: translateY(-2px);
    }

    /* Search and Sort Toolbar */
    .catalog-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        background: #ffffff;
        padding: 12px 20px;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        margin-bottom: 32px;
        flex-wrap: wrap;
    }
    .search-input-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
        min-width: 240px;
    }
    .search-input-wrapper input {
        width: 100%;
        border: none;
        outline: none;
        font-size: 14px;
        background: transparent;
        color: var(--text-main);
    }
    .sort-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: var(--text-muted);
    }
    .sort-select {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 13px;
        font-weight: 600;
        background: #faf8f5;
        color: var(--text-main);
        outline: none;
    }

    /* Product Grid */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
    }

    .product-card {
        background: #ffffff;
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 1px solid var(--border-color);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        position: relative;
    }
    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: var(--shadow-hover);
        border-color: #d6cbbd;
    }

    .product-media {
        position: relative;
        height: 360px;
        background: #f5eedb;
        overflow: hidden;
    }
    .product-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .product-card:hover .product-img {
        transform: scale(1.06);
    }

    .product-tag-featured {
        position: absolute;
        top: 14px;
        left: 14px;
        background: rgba(25, 22, 20, 0.85);
        color: #e5b88f;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 5px 12px;
        border-radius: 4px;
        backdrop-filter: blur(4px);
    }

    .product-quick-actions {
        position: absolute;
        bottom: 14px;
        left: 14px;
        right: 14px;
        display: flex;
        gap: 8px;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.25s ease;
    }
    .product-card:hover .product-quick-actions {
        opacity: 1;
        transform: translateY(0);
    }

    .btn-quick-view {
        flex: 1;
        background: rgba(255, 255, 255, 0.94);
        color: #191614;
        font-size: 12px;
        font-weight: 700;
        padding: 10px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        transition: all 0.2s;
    }
    .btn-quick-view:hover {
        background: #191614;
        color: #ffffff;
    }

    .btn-quick-whatsapp {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #25D366;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
    }

    .product-details {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }
    .product-category {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: var(--primary-dark);
        margin-bottom: 6px;
    }
    .product-title {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 20px;
        font-weight: 700;
        line-height: 1.25;
        color: var(--text-main);
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .product-sizes-chip {
        font-size: 11px;
        color: #665f57;
        background: #f5f0e8;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
        margin-bottom: 14px;
        align-self: flex-start;
    }
    .product-bottom-row {
        margin-top: auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 14px;
        border-top: 1px solid #f2ede4;
    }
    .product-price {
        font-size: 18px;
        font-weight: 800;
        color: #191614;
    }
    .btn-add-bag {
        background: #191614;
        color: #ffffff;
        padding: 8px 14px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }
    .btn-add-bag:hover {
        background: var(--primary-dark);
    }

    /* Instagram Banner Section */
    .instagram-banner {
        max-width: 1280px;
        margin: 80px auto 0;
        padding: 50px 30px;
        background: linear-gradient(135deg, #fdf9f4 0%, #f4ede3 100%);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 30px;
        flex-wrap: wrap;
    }
    .insta-content h3 {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    .insta-content p {
        font-size: 14px;
        color: var(--text-muted);
        max-width: 500px;
    }
    .btn-insta-follow {
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
        color: #ffffff;
        padding: 14px 28px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 8px 20px rgba(220, 39, 67, 0.25);
        transition: transform 0.2s;
    }
    .btn-insta-follow:hover {
        transform: translateY(-2px);
    }

    /* Boutique Store Locator */
    .store-location-card {
        max-width: 1280px;
        margin: 60px auto 0;
        padding: 0 24px;
    }
    .location-box {
        background: #ffffff;
        border-radius: var(--radius-lg);
        padding: 40px;
        border: 1px solid var(--border-color);
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        align-items: center;
    }
    @media (max-width: 900px) {
        .location-box { grid-template-columns: 1fr; }
    }
    @media (max-width: 640px) {
        .product-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }
        .product-media {
            height: 220px;
        }
        .product-info {
            padding: 12px 10px;
        }
        .product-title {
            font-size: 13.5px;
            margin-bottom: 4px;
            line-height: 1.3;
        }
        .product-sizes-chip {
            font-size: 10px;
            padding: 2px 6px;
            margin-bottom: 8px;
        }
        .product-price {
            font-size: 15px;
        }
        .product-bottom-row {
            padding-top: 10px;
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
        .btn-add-bag {
            width: 100%;
            justify-content: center;
            padding: 8px 10px;
            font-size: 11.5px;
        }
        .catalog-section {
            padding: 0 14px;
            margin: 36px auto;
        }
        .section-header {
            margin-bottom: 20px;
        }
        .section-title h2 {
            font-size: 28px;
        }
        .catalog-toolbar {
            padding: 10px 14px;
            gap: 10px;
        }
        .search-input-wrapper {
            min-width: 100%;
        }
        .sort-wrapper {
            width: 100%;
            justify-content: space-between;
        }
        .category-pills {
            margin-bottom: 20px;
            gap: 6px;
        }
        .category-pill {
            padding: 8px 16px;
            font-size: 12px;
        }
        .hero-section {
            padding: 50px 16px 60px;
        }
        .hero-title {
            font-size: 34px;
        }
        .btn-hero-primary, .btn-hero-whatsapp {
            width: 100%;
            justify-content: center;
        }
        .hero-img-main {
            height: 380px;
        }
        .instagram-banner {
            padding: 30px 20px;
            margin-top: 50px;
        }
        .location-box {
            padding: 24px 18px;
        }
    }
    @media (max-width: 360px) {
        .product-grid {
            grid-template-columns: 1fr;
        }
        .product-media {
            height: 280px;
        }
        .product-bottom-row {
            flex-direction: row;
            align-items: center;
        }
        .btn-add-bag {
            width: auto;
        }
    }
    .pagination svg { width: 18px; height: 18px; }
    .pagination nav { display: flex; align-items: center; justify-content: center; gap: 6px; }
    .pagination a, .pagination span { display: inline-flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; border-radius: 8px; font-size: 13px; font-weight: 700; background: #fff; border: 1px solid var(--border-color); color: var(--text-main); }
    .pagination span[aria-current="page"] span { background: #181513; color: #f5d496; border-color: #c58b2b; }
</style>
@endpush

@section('content')

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-pattern"></div>
        <div class="hero-container">
            <div>
                <div class="hero-badge">
                    <i data-lucide="sparkles" style="width: 14px; height: 14px;"></i>
                    <span>Madina Estate • Sizes UK 10 – 22</span>
                </div>
                <h1 class="hero-title">
                    Celebrate Every Curve In <em>Effortless Style</em>.
                </h1>
                <p class="hero-subtitle">
                    Accra’s destination for vibrant, curve-flattering dresses, statement tees, matching co-ord sets, and figure-sculpting denim. Order directly online or via WhatsApp.
                </p>
                <div class="hero-actions">
                    <a href="#catalog" class="btn-hero-primary">
                        <i data-lucide="shopping-bag" style="width: 18px; height: 18px;"></i>
                        <span>Shop Catalog</span>
                    </a>
                    <button type="button" onclick="openWhatsAppStylist(null)" class="btn-hero-whatsapp" style="cursor: pointer; border: none;">
                        <i data-lucide="message-circle" style="width: 18px; height: 18px;"></i>
                        <span>Order on WhatsApp</span>
                    </button>
                </div>
            </div>

            <div class="hero-visual">
                <div class="hero-card-stack">
                    <img src="https://images.unsplash.com/photo-1595777457583-95e059d581b8?auto=format&fit=crop&w=800&q=80" alt="Curves & Tees Model" class="hero-img-main">
                    <div class="hero-floating-tag">
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: #e5b88f; display: flex; align-items: center; justify-content: center; color: #191614; font-weight: 800;">
                            ✨
                        </div>
                        <div>
                            <strong style="color: #fff; font-size: 14px; display: block;">New Collection Live</strong>
                            <span style="color: #e5b88f; font-size: 12px;">Nationwide Delivery in Ghana</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Highlights -->
    <div class="highlights-bar">
        <div class="highlights-container">
            <div class="highlight-card">
                <div class="highlight-icon">
                    <i data-lucide="map-pin"></i>
                </div>
                <div class="highlight-text">
                    <h5>Madina Estate Showroom</h5>
                    <p>Accra pickup & fast dispatch</p>
                </div>
            </div>
            <div class="highlight-card">
                <div class="highlight-icon">
                    <i data-lucide="smile"></i>
                </div>
                <div class="highlight-text">
                    <h5>Curved Cuts (UK 10-22)</h5>
                    <p>Designed with zero waist-gap</p>
                </div>
            </div>
            <div class="highlight-card">
                <div class="highlight-icon">
                    <i data-lucide="message-circle" style="color: #25D366;"></i>
                </div>
                <div class="highlight-text">
                    <h5>Instant WhatsApp Care</h5>
                    <p>Call or text +233 57 103 8444</p>
                </div>
            </div>
            <div class="highlight-card">
                <div class="highlight-icon">
                    <i data-lucide="credit-card"></i>
                </div>
                <div class="highlight-text">
                    <h5>Flexible Checkout</h5>
                    <p>MoMo, Paystack or WhatsApp</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Catalog Section -->
    <section class="catalog-section" id="catalog">
        <div class="section-header">
            <div class="section-title">
                <h2>Ready-to-Wear Catalog</h2>
                <p>Browse our hand-picked styles. Select your size and order via WhatsApp or Online Checkout.</p>
            </div>
            <div>
                <a href="https://wa.me/233571038444" target="_blank" class="btn-whatsapp-nav" style="box-shadow: none;">
                    <i data-lucide="help-circle"></i>
                    <span>Need Size Advice? Chat Now</span>
                </a>
            </div>
        </div>

        <!-- Category Pills -->
        <div class="category-pills">
            <a href="{{ route('store.index') }}" class="category-pill {{ !request('category') ? 'active' : '' }}">
                All Outfits ({{ $products->total() }})
            </a>
            @foreach($categories as $category)
                <a href="{{ route('store.index', ['category' => $category->id]) }}" class="category-pill {{ request('category') == $category->id ? 'active' : '' }}">
                    {{ $category->name }} ({{ $category->products_count }})
                </a>
            @endforeach
        </div>

        <!-- Search & Sort Toolbar -->
        <form method="GET" action="{{ route('store.index') }}" class="catalog-toolbar">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif

            <div class="search-input-wrapper">
                <i data-lucide="search" style="color: var(--text-muted); width: 18px; height: 18px;"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search dresses, tees, sets, pants...">
                @if(!empty($search))
                    <a href="{{ request('category') ? route('store.index', ['category' => request('category')]) : route('store.index') }}" style="color: var(--text-muted); padding: 4px;" title="Clear search">
                        <i data-lucide="x" style="width: 16px; height: 16px;"></i>
                    </a>
                @endif
                <button type="submit" class="btn-add-bag" style="padding: 6px 12px; margin-left: 4px;">
                    <span>Search</span>
                </button>
            </div>

            <div class="sort-wrapper">
                <label for="sortSelect">Sort by:</label>
                <select name="sort" id="sortSelect" class="sort-select" onchange="this.form.submit()">
                    <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Newest Arrivals</option>
                    <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="name_asc" {{ $sort === 'name_asc' ? 'selected' : '' }}>Alphabetical (A-Z)</option>
                </select>
            </div>
        </form>

        <!-- Product Grid -->
        @if($products->isEmpty())
            <div style="text-align: center; padding: 80px 20px; background: #fff; border-radius: var(--radius-md); border: 1px dashed var(--border-color);">
                <i data-lucide="search-x" style="width: 48px; height: 48px; color: var(--text-muted); margin-bottom: 12px;"></i>
                <h3 style="font-size: 18px; margin-bottom: 6px;">No products found</h3>
                <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 20px;">Try searching for another piece or reset your filters.</p>
                <a href="{{ route('store.index') }}" class="btn-checkout-primary" style="display: inline-flex; width: auto; padding: 10px 20px;">
                    View All Products
                </a>
            </div>
        @else
            <div class="product-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        <div class="product-media">
                            <a href="{{ route('store.product', $product) }}" style="display: block; width: 100%; height: 100%;">
                                <img src="{{ $product->image_url ?: 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $product->name }}" class="product-img">
                            </a>

                            @if($product->is_featured)
                                <div class="product-tag-featured">✨ Featured</div>
                            @endif

                            <div class="product-quick-actions">
                                <button type="button" class="btn-quick-view" onclick="openQuickView({{ $product->id }})">
                                    <i data-lucide="eye" style="width: 14px; height: 14px;"></i>
                                    <span>Quick View</span>
                                </button>
                                <button type="button" onclick="openWhatsAppStylist({ id: {{ $product->id }}, name: {{ json_encode($product->name) }}, price: {{ (float)$product->price }}, size: '{{ $product->sizes_list[0] ?? "UK 14" }}' })" class="btn-quick-whatsapp" title="Inquire on WhatsApp" style="border: none; cursor: pointer;">
                                    <i data-lucide="message-circle" style="width: 18px; height: 18px;"></i>
                                </button>
                            </div>
                        </div>

                        <div class="product-details">
                            <span class="product-category">{{ $product->category?->name ?? 'Collection' }}</span>
                            <h3 class="product-title">
                                <a href="{{ route('store.product', $product) }}">{{ $product->name }}</a>
                            </h3>
                            <div class="product-sizes-chip">
                                <span>Sizes: {{ $product->sizes ?? 'UK 10 - 22' }}</span>
                            </div>

                            <div class="product-bottom-row">
                                <div class="product-price">GH₵ {{ number_format((float) $product->price, 2) }}</div>
                                <button type="button" class="btn-add-bag" onclick="addToCart({{ json_encode(['id' => $product->id, 'name' => $product->name, 'price' => (float) $product->price, 'image_url' => $product->image_url, 'sizes' => $product->sizes_list]) }})">
                                    <i data-lucide="shopping-bag" style="width: 14px; height: 14px;"></i>
                                    <span>Add</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Boutique Pagination -->
            {{ $products->links('store.partials.pagination') }}
        @endif
    </section>

    <!-- Instagram Social Banner -->
    <div class="instagram-banner">
        <div class="insta-content">
            <span style="font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: var(--primary-dark); font-weight: 800;">JOIN OUR CURVY COMMUNITY</span>
            <h3>Follow Us on Instagram @curves_and_tees</h3>
            <p>Catch our latest arrivals, try-on hauls, customer styling reviews, and flash promotions directly on Instagram.</p>
        </div>
        <div>
            <a href="https://www.instagram.com/curves_and_tees/?hl=en" target="_blank" class="btn-insta-follow">
                <i data-lucide="instagram"></i>
                <span>Follow @curves_and_tees</span>
            </a>
        </div>
    </div>

    <!-- Store Locator & Visit Section -->
    <section class="store-location-card" id="location">
        <div class="location-box">
            <div>
                <span style="font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: var(--primary-dark); font-weight: 800;">PHYSICAL BOUTIQUE</span>
                <h2 class="serif" style="font-size: 34px; margin: 10px 0 16px; line-height: 1.2;">Visit Us at Madina Estate, Accra</h2>
                <p style="color: var(--text-muted); font-size: 14px; line-height: 1.7; margin-bottom: 24px;">
                    Prefer fitting before you purchase? Visit our walk-in boutique in Madina Estate. Friendly personal styling assistance and fitting rooms available.
                </p>
                <div style="display: flex; flex-direction: column; gap: 12px; font-size: 14px;">
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <i data-lucide="map-pin" style="color: var(--primary-dark); width: 18px;"></i>
                        <span><strong>Address:</strong> Madina Estate, Accra, Ghana</span>
                    </div>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <i data-lucide="phone-call" style="color: var(--primary-dark); width: 18px;"></i>
                        <span><strong>Hotline:</strong> +233 57 103 8444</span>
                    </div>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <i data-lucide="clock" style="color: var(--primary-dark); width: 18px;"></i>
                        <span><strong>Hours:</strong> Monday – Saturday (9:00 AM – 7:00 PM)</span>
                    </div>
                </div>
            </div>

            <div style="background: #f4ede5; border-radius: var(--radius-md); padding: 30px; text-align: center; border: 1px dashed var(--primary);">
                <div style="width: 56px; height: 56px; border-radius: 50%; background: #25D366; color: #fff; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                    <i data-lucide="message-circle" style="width: 28px; height: 28px;"></i>
                </div>
                <h4 class="serif" style="font-size: 22px; margin-bottom: 8px;">Order Directly on WhatsApp</h4>
                <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 20px;">
                    Send screenshots of any item you love from our catalog or Instagram to our WhatsApp line for instant booking!
                </p>
                <button type="button" onclick="openWhatsAppStylist(null)" class="btn-checkout-whatsapp" style="display: inline-flex; width: auto; padding: 12px 28px; margin: 0 auto; border: none; cursor: pointer;">
                    <i data-lucide="message-circle"></i>
                    <span>Chat +233 57 103 8444</span>
                </button>
            </div>
        </div>
    </section>

@endsection
