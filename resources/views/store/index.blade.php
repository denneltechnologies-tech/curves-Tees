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
        max-width: 1440px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 44% 56%;
        gap: 48px;
        align-items: center;
        position: relative;
        z-index: 2;
    }
    @media (max-width: 980px) {
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
        width: 100%;
    }
    .hero-carousel-container {
        position: relative;
        max-width: 820px;
        width: 100%;
        margin: 0 auto;
    }
    .hero-carousel {
        position: relative;
        width: 100%;
        height: 520px;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.45);
        border: 2px solid rgba(229, 184, 143, 0.25);
        background: #191614;
    }
    @media (max-width: 1100px) {
        .hero-carousel { height: 480px; }
    }
    @media (max-width: 600px) {
        .hero-carousel { height: 380px; border-radius: 18px; }
    }

    .hero-slide {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 1.2s cubic-bezier(0.16, 1, 0.3, 1);
        transform: scale(1.04);
    }
    .hero-slide.active {
        opacity: 1;
        visibility: visible;
        transform: scale(1);
        z-index: 2;
    }
    .hero-slide img, .hero-slide video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .hero-slide-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(0,0,0,0.05) 0%, rgba(0,0,0,0.15) 50%, rgba(21,19,17,0.7) 100%);
    }

    /* Carousel Navigation Arrows */
    .hero-carousel-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(25, 22, 20, 0.7);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(229, 184, 143, 0.3);
        color: #f5eedb;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.2s ease;
    }
    .hero-carousel-arrow:hover {
        background: #191614;
        border-color: var(--primary);
        color: var(--primary);
        transform: translateY(-50%) scale(1.08);
    }
    .hero-carousel-arrow.prev { left: 12px; }
    .hero-carousel-arrow.next { right: 12px; }
    @media (max-width: 600px) {
        .hero-carousel-arrow { width: 34px; height: 34px; }
    }

    /* Carousel Dot Indicators */
    .hero-carousel-dots {
        position: absolute;
        top: 16px;
        right: 16px;
        display: flex;
        gap: 6px;
        z-index: 10;
        background: rgba(25, 22, 20, 0.65);
        backdrop-filter: blur(6px);
        padding: 6px 12px;
        border-radius: 50px;
        border: 1px solid rgba(229, 184, 143, 0.2);
    }
    .hero-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.35);
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        padding: 0;
    }
    .hero-dot.active {
        width: 22px;
        border-radius: 10px;
        background: var(--primary);
    }

    /* Video Toggle Switcher Pill */
    .hero-media-switcher {
        position: absolute;
        top: 16px;
        left: 16px;
        z-index: 10;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(25, 22, 20, 0.85);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(229, 184, 143, 0.3);
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 11px;
        font-weight: 700;
        color: #e5b88f;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .hero-media-switcher:hover {
        background: #191614;
        border-color: var(--primary);
        color: #ffffff;
    }

    .hero-floating-tag {
        position: absolute;
        bottom: 20px;
        left: -15px;
        background: rgba(25, 22, 20, 0.92);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(229, 184, 143, 0.3);
        padding: 12px 18px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.3);
        z-index: 10;
        transition: all 0.3s ease;
    }
    @media (max-width: 600px) {
        .hero-floating-tag { left: 10px; bottom: 10px; padding: 10px 14px; }
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

    /* Curated Collections Section (The Lotte Accra Editorial Style) */
    .collections-section {
        max-width: 1280px;
        margin: 60px auto 20px;
        padding: 0 24px;
    }
    .collections-header {
        text-align: center;
        max-width: 700px;
        margin: 0 auto 40px;
    }
    .collections-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 18px;
        border-radius: 50px;
        background: rgba(197, 139, 43, 0.1);
        color: var(--primary-dark);
        border: 1px solid rgba(197, 139, 43, 0.25);
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 14px;
    }
    .collections-title {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 44px;
        line-height: 1.15;
        font-weight: 700;
        letter-spacing: -0.5px;
        color: var(--text-main);
        margin-bottom: 12px;
    }
    .collections-title em {
        color: var(--primary-dark);
        font-style: italic;
    }
    .collections-subtitle {
        font-size: 15px;
        line-height: 1.7;
        color: var(--text-muted);
    }
    .collections-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
    }
    @media (max-width: 1100px) {
        .collections-grid { grid-template-columns: repeat(3, 1fr); gap: 18px; }
    }
    @media (max-width: 768px) {
        .collections-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; }
        .collections-title { font-size: 32px; }
        .collections-section { margin: 40px auto 16px; padding: 0 16px; }
    }
    @media (max-width: 440px) {
        .collections-grid { grid-template-columns: 1fr; gap: 14px; }
    }
    .collection-tile {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        background: #191614;
        display: block;
        text-decoration: none;
        box-shadow: 0 6px 20px rgba(0,0,0,0.05);
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        aspect-ratio: 4 / 5;
    }
    .collection-tile:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(0,0,0,0.18);
        border-color: var(--primary);
    }
    .collection-tile.active-tile {
        border: 2px solid var(--primary);
        box-shadow: 0 0 0 4px rgba(197, 139, 43, 0.25);
    }
    .collection-tile-media {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }
    .collection-tile-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1), filter 0.4s ease;
        filter: brightness(0.86);
    }
    .collection-tile:hover .collection-tile-media img {
        transform: scale(1.08);
        filter: brightness(0.96);
    }
    .collection-tile-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(0,0,0,0.05) 0%, rgba(18,15,13,0.3) 40%, rgba(18,15,13,0.92) 100%);
        transition: background 0.3s ease;
    }
    .collection-tile:hover .collection-tile-overlay {
        background: linear-gradient(180deg, rgba(0,0,0,0.02) 0%, rgba(18,15,13,0.2) 30%, rgba(18,15,13,0.95) 100%);
    }
    .collection-tile-content {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 20px 18px;
        z-index: 2;
        display: flex;
        flex-direction: column;
    }
    .collection-tile-tag {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #e5b88f;
        margin-bottom: 6px;
    }
    .collection-tile-title {
        color: #ffffff;
        font-size: 21px;
        font-weight: 700;
        line-height: 1.15;
        margin-bottom: 8px;
        transition: color 0.2s ease;
    }
    .collection-tile:hover .collection-tile-title {
        color: #f7e0b5;
    }
    .collection-tile-link {
        font-size: 12px;
        font-weight: 700;
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        opacity: 0.85;
        transition: all 0.2s ease;
    }
    .collection-tile:hover .collection-tile-link {
        opacity: 1;
        color: #e5b88f;
        transform: translateX(4px);
    }

    /* Catalog Section */
    .catalog-section {
        max-width: 1280px;
        margin: 50px auto;
        padding: 0 24px;
    }
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 32px;
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
                    <span>{{ $heroSettings['hero_badge'] ?? 'ACCRA CONCEPT STORE • SIZES UK 10 – 22 • CURATED SILHOUETTES' }}</span>
                </div>
                <h1 class="hero-title">
                    {!! preg_replace('/\*(.*?)\*/', '<em>$1</em>', e($heroSettings['hero_title'] ?? "Accra's Premier Destination for *Curve-Flattering* Luxury")) !!}
                </h1>
                <p class="hero-subtitle">
                    {{ $heroSettings['hero_subtitle'] ?? 'Curves & Tees is Accra’s luxury destination for curve-celebrating corporate wears, evening gowns, matching two-piece sets, and figure-sculpting denim. Hand-picked for effortless elegance.' }}
                </p>
                @php
                    $hasVideo = !empty($heroSettings['hero_video_url']);
                    $videoMode = $heroSettings['hero_mode'] ?? 'both';
                    $isVideoPrimary = $hasVideo && ($videoMode === 'video_primary' || $heroSlides->isEmpty());
                    $vUrl = $heroSettings['hero_video_url'] ?? '';
                    $formattedVideoUrl = \App\Models\HeroSlide::formatVideoUrl($vUrl);
                    $isGdrive = preg_match('#drive\.google\.com/(?:file/d/|open\?id=|uc\?id=)([a-zA-Z0-9_-]+)#', $vUrl, $gm);
                    $isYt = preg_match('#(?:youtube\.com/(?:watch\?v=|embed/)|youtu\.be/)([a-zA-Z0-9_-]+)#', $vUrl, $ym);
                @endphp

                <div class="hero-actions">
                    <a href="#collections" class="btn-hero-primary">
                        <i data-lucide="sparkles" style="width: 18px; height: 18px;"></i>
                        <span>Explore 12 Collections</span>
                    </a>
                    @if($hasVideo)
                        <button type="button" onclick="toggleHeroMedia(true)" class="btn-hero-primary" style="background: rgba(229, 184, 143, 0.15); color: #e5b88f; border: 1px solid rgba(229, 184, 143, 0.4); box-shadow: none;">
                            <i data-lucide="play-circle" style="width: 18px; height: 18px;"></i>
                            <span>Watch Runway Video</span>
                        </button>
                    @endif
                    <button type="button" onclick="openWhatsAppStylist(null)" class="btn-hero-whatsapp" style="cursor: pointer; border: none;">
                        <i data-lucide="message-circle" style="width: 18px; height: 18px;"></i>
                        <span>Order on WhatsApp</span>
                    </button>
                </div>
            </div>

            <div class="hero-visual">
                <div class="hero-carousel-container" onmouseenter="stopHeroAutoPlay()" onmouseleave="startHeroAutoPlay()">
                    <!-- Media Switcher (Toggle between Video & Photo Lookbook) -->
                    @if($hasVideo)
                        <button type="button" class="hero-media-switcher" id="heroMediaSwitcher" onclick="toggleHeroMedia()">
                            <i data-lucide="{{ $isVideoPrimary ? 'image' : 'play' }}" style="width: 14px; height: 14px;"></i>
                            <span>{{ $isVideoPrimary ? 'View Lookbook Photos' : 'Watch Video Reel' }}</span>
                        </button>
                    @endif

                    <!-- Carousel Slide Dots -->
                    <div class="hero-carousel-dots" id="heroCarouselDots">
                        @foreach($heroSlides as $i => $slide)
                            <button type="button" class="hero-dot {{ (!$isVideoPrimary && $i === 0) ? 'active' : '' }}" onclick="showHeroSlide({{ $i }})" aria-label="Slide {{ $i + 1 }}"></button>
                        @endforeach
                    </div>

                    <!-- Previous & Next Arrows -->
                    <button type="button" class="hero-carousel-arrow prev" onclick="prevHeroSlide()" aria-label="Previous Look">
                        <i data-lucide="chevron-left" style="width: 18px; height: 18px;"></i>
                    </button>
                    <button type="button" class="hero-carousel-arrow next" onclick="nextHeroSlide()" aria-label="Next Look">
                        <i data-lucide="chevron-right" style="width: 18px; height: 18px;"></i>
                    </button>

                    <div class="hero-carousel">
                        @foreach($heroSlides as $i => $slide)
                            <div class="hero-slide {{ (!$isVideoPrimary && $i === 0) ? 'active' : '' }}" data-look="{{ $slide->tag ? $slide->tag . ' • ' : '' }}{{ $slide->title }}">
                                <img src="{{ $slide->image_url }}" alt="{{ $slide->title }}">
                                <div class="hero-slide-overlay"></div>
                                <div style="position: absolute; bottom: 20px; right: 24px; text-align: right; z-index: 4; max-width: 65%;">
                                    @if($slide->tag)
                                        <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 2px; color: #e5b88f; font-weight: 800; margin-bottom: 4px;">{{ $slide->tag }}</div>
                                    @endif
                                    <h3 style="font-family: 'Cormorant Garamond', Georgia, serif; font-size: 24px; color: #fff; margin-bottom: 6px; line-height: 1.15;">{{ $slide->title }}</h3>
                                    @if($slide->button_text && $slide->button_link)
                                        <a href="{{ $slide->button_link }}" class="btn-hero-slide" style="display: inline-flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 700; color: #191614; background: #e5b88f; padding: 6px 14px; border-radius: 20px; text-decoration: none;">
                                            <span>{{ $slide->button_text }}</span> &rarr;
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        <!-- Video Slide (Supports Direct MP4, Google Drive, or YouTube) -->
                        @if($hasVideo)
                            <div class="hero-slide {{ $isVideoPrimary ? 'active' : '' }}" id="heroVideoSlide" data-look="{{ $heroSettings['hero_video_title'] ?? 'Runway Lookbook Video' }}">
                                @if($isGdrive)
                                    <iframe id="heroGdriveFrame" src="https://drive.google.com/file/d/{{ $gm[1] }}/preview" width="100%" height="100%" allow="autoplay; fullscreen" style="border: none; width: 100%; height: 100%;"></iframe>
                                @elseif($isYt)
                                    <iframe id="heroYtFrame" src="https://www.youtube.com/embed/{{ $ym[1] }}?autoplay=1&mute=1&loop=1&playlist={{ $ym[1] }}" width="100%" height="100%" allow="autoplay; encrypted-media; fullscreen" style="border: none; width: 100%; height: 100%;"></iframe>
                                @else
                                    <video id="heroVideo" src="{{ $formattedVideoUrl }}" loop muted autoplay playsinline controls poster="{{ $heroSlides->first()?->image_url }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        <source src="{{ $formattedVideoUrl }}" type="video/mp4">
                                    </video>
                                @endif
                                <div class="hero-slide-overlay" style="pointer-events: none;"></div>
                            </div>
                        @endif
                    </div>

                    <!-- Dynamic Floating Tag -->
                    <div class="hero-floating-tag">
                        <div style="width: 42px; height: 42px; border-radius: 50%; background: #e5b88f; display: flex; align-items: center; justify-content: center; color: #191614; font-weight: 800; flex-shrink: 0;">
                            ✨
                        </div>
                        <div>
                            <strong style="color: #fff; font-size: 13.5px; display: block;" id="heroLookTag">
                                {{ $heroSlides->first()?->title ?? 'Look 01: The Accra Concept Edit' }}
                            </strong>
                            <span style="color: #e5b88f; font-size: 11.5px;">Sizes UK 10–22 • Ghana Nationwide Delivery</span>
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

    @php
        $collectionImages = [
            'Corporate Wears' => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?auto=format&fit=crop&w=800&q=80',
            'Party Dresses' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?auto=format&fit=crop&w=800&q=80',
            'Evening Dresses' => 'https://images.unsplash.com/photo-1566174053879-31528523f8ae?auto=format&fit=crop&w=800&q=80',
            'Luxury Wears' => 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=800&q=80',
            'Two Piece Sets' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=800&q=80',
            'Casuals' => 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?auto=format&fit=crop&w=800&q=80',
            'Tops, Shirts & Tees' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=800&q=80',
            'Denim' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?auto=format&fit=crop&w=800&q=80',
            'Tummy Control & Bras' => 'https://images.unsplash.com/photo-1582533561751-ef6f6ab93a2e?auto=format&fit=crop&w=800&q=80',
            'Pants & Shorts' => 'https://images.unsplash.com/photo-1509551388413-e18d0ac5d495?auto=format&fit=crop&w=800&q=80',
            'Shoes & Bags' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=800&q=80',
            'Accessories' => 'https://images.unsplash.com/photo-1624222247344-550fb60583dc?auto=format&fit=crop&w=800&q=80',
        ];
    @endphp

    <!-- Curated Collections Showcase (The Lotte Accra Concept Style) -->
    <section class="collections-section" id="collections">
        <div class="collections-header">
            <div class="collections-badge">
                <i data-lucide="sparkles" style="width: 14px; height: 14px;"></i>
                <span>The Curated Edit • 12 Collections</span>
            </div>
            <h2 class="collections-title serif">
                Explore By <em>Curated Collection</em>
            </h2>
            <p class="collections-subtitle">
                From commanding corporate wear and evening satin gowns to waist-snatching denim, luxury two-piece sets, and sculpting essentials.
            </p>
        </div>

        <div class="collections-grid">
            @foreach($categories as $cat)
                @php
                    $tileImg = $collectionImages[$cat->name] ?? 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=800&q=80';
                @endphp
                <a href="{{ route('store.index', ['category' => $cat->id]) }}#catalog" class="collection-tile {{ request('category') == $cat->id ? 'active-tile' : '' }}">
                    <div class="collection-tile-media">
                        <img src="{{ $tileImg }}" alt="{{ $cat->name }}" loading="lazy">
                        <div class="collection-tile-overlay"></div>
                    </div>
                    <div class="collection-tile-content">
                        <span class="collection-tile-tag">{{ $cat->products_count }} {{ Str::plural('Style', $cat->products_count) }}</span>
                        <h3 class="collection-tile-title serif">{{ $cat->name }}</h3>
                        <span class="collection-tile-link">Shop Collection &rarr;</span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

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

        @if($activeCategory)
            <div style="background: #faf5ee; border: 1.5px solid rgba(197, 139, 43, 0.4); border-radius: 12px; padding: 14px 20px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 11px; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 800; color: var(--primary-dark); background: rgba(197, 139, 43, 0.15); padding: 4px 10px; border-radius: 50px;">FILTERED COLLECTION</span>
                    <h3 class="serif" style="font-size: 22px; font-weight: 700; color: #191614; margin: 0;">{{ $activeCategory->name }}</h3>
                    <span style="font-size: 13px; color: #736c66;">({{ $products->total() }} pieces found)</span>
                </div>
                <a href="{{ route('store.index') }}#catalog" style="font-size: 13px; font-weight: 700; color: #9e6c1a; text-decoration: underline; display: inline-flex; align-items: center; gap: 6px;">
                    <i data-lucide="x" style="width: 14px; height: 14px;"></i>
                    <span>Show All 12 Collections</span>
                </a>
            </div>
        @endif

        <!-- Category Pills (All 12 Collections) -->
        <div class="category-pills">
            <a href="{{ route('store.index') }}#catalog" class="category-pill {{ !request('category') ? 'active' : '' }}">
                All Outfits ({{ \App\Models\Product::where('status', 'active')->count() }})
            </a>
            @foreach($categories as $category)
                <a href="{{ route('store.index', ['category' => $category->id]) }}#catalog" class="category-pill {{ request('category') == $category->id ? 'active' : '' }}">
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

@push('scripts')
<script>
    let currentHeroSlide = 0;
    let heroInterval = null;

    function getHeroSlides() {
        return document.querySelectorAll('.hero-carousel .hero-slide:not(#heroVideoSlide)');
    }

    function getHeroDots() {
        return document.querySelectorAll('.hero-dot');
    }

    function showHeroSlide(index) {
        const slides = getHeroSlides();
        const dots = getHeroDots();
        const videoSlide = document.getElementById('heroVideoSlide');

        if (videoSlide && videoSlide.classList.contains('active')) {
            const video = videoSlide.querySelector('video');
            if (video) video.pause();
            videoSlide.classList.remove('active');
            const switcher = document.getElementById('heroMediaSwitcher');
            if (switcher) switcher.innerHTML = '<i data-lucide="play" style="width: 14px; height: 14px;"></i><span>Watch Video Reel</span>';
        }

        if (!slides.length) return;
        index = (index + slides.length) % slides.length;

        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });
        currentHeroSlide = index;

        const activeSlide = slides[index];
        const lookName = activeSlide ? activeSlide.getAttribute('data-look') : '';
        const tagEl = document.getElementById('heroLookTag');
        if (tagEl && lookName) {
            tagEl.innerText = lookName;
        }
        if (window.lucide) lucide.createIcons();
    }

    function nextHeroSlide() {
        const slides = getHeroSlides();
        if (!slides.length) return;
        showHeroSlide(currentHeroSlide + 1);
    }

    function prevHeroSlide() {
        const slides = getHeroSlides();
        if (!slides.length) return;
        showHeroSlide(currentHeroSlide - 1);
    }

    function startHeroAutoPlay() {
        stopHeroAutoPlay();
        const slides = getHeroSlides();
        if (slides.length > 1) {
            heroInterval = setInterval(nextHeroSlide, 5000);
        }
    }

    function stopHeroAutoPlay() {
        if (heroInterval) clearInterval(heroInterval);
    }

    function toggleHeroMedia() {
        const videoSlide = document.getElementById('heroVideoSlide');
        const switcherBtn = document.getElementById('heroMediaSwitcher');
        const slides = getHeroSlides();
        const dots = getHeroDots();
        if (!videoSlide) return;

        const isVideoActive = videoSlide.classList.contains('active');
        const video = videoSlide.querySelector('video');

        if (!isVideoActive) {
            stopHeroAutoPlay();
            slides.forEach(s => s.classList.remove('active'));
            dots.forEach(d => d.classList.remove('active'));
            videoSlide.classList.add('active');
            if (video) {
                video.currentTime = 0;
                video.play().catch(() => {});
            }
            const tagEl = document.getElementById('heroLookTag');
            if (tagEl) tagEl.innerText = videoSlide.getAttribute('data-look') || 'Runway Video Lookbook';
            if (switcherBtn) switcherBtn.innerHTML = '<i data-lucide="image" style="width: 14px; height: 14px;"></i><span>View Lookbook Photos</span>';
        } else {
            if (video) video.pause();
            showHeroSlide(0);
            startHeroAutoPlay();
            if (switcherBtn) switcherBtn.innerHTML = '<i data-lucide="play" style="width: 14px; height: 14px;"></i><span>Watch Video Reel</span>';
        }
        if (window.lucide) lucide.createIcons();
    }

    document.addEventListener('DOMContentLoaded', () => {
        startHeroAutoPlay();
    });
</script>
@endpush
