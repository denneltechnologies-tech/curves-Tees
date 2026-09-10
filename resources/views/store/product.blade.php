@extends('store.layouts.app')

@section('title', $product->name . ' — Curves & Tees')

@push('styles')
<style>
    .product-page-container {
        max-width: 1240px;
        margin: 50px auto 80px;
        padding: 0 24px;
    }
    .product-detail-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
        align-items: start;
    }
    @media (max-width: 860px) {
        .product-detail-layout { grid-template-columns: 1fr; gap: 30px; }
    }

    .product-gallery-frame {
        border-radius: var(--radius-lg);
        overflow: hidden;
        background: #f4ede5;
        height: 600px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-soft);
    }
    .product-gallery-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    @media (max-width: 600px) {
        .product-gallery-frame { height: 420px; }
    }

    .product-info-panel {
        padding: 10px 0;
    }
    .badge-category {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--primary-dark);
        margin-bottom: 8px;
        display: inline-block;
    }
    .product-heading {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 38px;
        font-weight: 700;
        line-height: 1.15;
        margin-bottom: 12px;
        color: var(--text-main);
    }
    .product-price-tag {
        font-size: 26px;
        font-weight: 800;
        color: #191614;
        margin-bottom: 20px;
    }
    .product-desc {
        font-size: 15px;
        line-height: 1.8;
        color: var(--text-muted);
        margin-bottom: 30px;
        padding-bottom: 24px;
        border-bottom: 1px solid var(--border-color);
    }

    .size-selection-area {
        margin-bottom: 30px;
    }
    .size-selection-area label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 10px;
    }
    .size-buttons-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .size-btn-choice {
        padding: 10px 18px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        background: #ffffff;
        font-size: 13px;
        font-weight: 700;
        color: var(--text-main);
        cursor: pointer;
        transition: all 0.2s;
    }
    .size-btn-choice:hover, .size-btn-choice.active {
        background: #191614;
        color: #ffffff;
        border-color: #191614;
        transform: translateY(-2px);
    }

    .actions-row {
        display: flex;
        gap: 14px;
        margin-top: 24px;
        flex-wrap: wrap;
    }
    .btn-buy-now {
        flex: 1;
        min-width: 180px;
        background: var(--text-main);
        color: #ffffff;
        padding: 16px 24px;
        border-radius: var(--radius-sm);
        font-size: 15px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.2s;
    }
    .btn-buy-now:hover {
        background: #000;
        transform: translateY(-2px);
    }
    .btn-whatsapp-inquire {
        background: #25D366;
        color: #ffffff;
        padding: 16px 24px;
        border-radius: var(--radius-sm);
        font-size: 15px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.2s;
        box-shadow: 0 6px 18px rgba(37, 211, 102, 0.25);
    }
    .btn-whatsapp-inquire:hover {
        background: #1eb855;
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
<div class="product-page-container">
    <div style="margin-bottom: 24px;">
        <a href="{{ route('store.index') }}" style="font-size: 13px; color: var(--text-muted); display: inline-flex; align-items: center; gap: 6px; font-weight: 600;">
            <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
            <span>Back to All Collections</span>
        </a>
    </div>

    <div class="product-detail-layout">
        <!-- Media -->
        <div class="product-gallery-frame">
            <img src="{{ $product->image_url ?: 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=800&q=80' }}" alt="{{ $product->name }}" class="product-gallery-img">
        </div>

        <!-- Details -->
        <div class="product-info-panel">
            <span class="badge-category">{{ $product->category?->name ?? 'Collection' }}</span>
            <h1 class="product-heading">{{ $product->name }}</h1>
            <div class="product-price-tag">GH₵ {{ number_format((float) $product->price, 2) }}</div>
            <p class="product-desc">{{ $product->description }}</p>

            <!-- Size Selector -->
            <div class="size-selection-area">
                <label>Select Size (UK Standard):</label>
                <div class="size-buttons-group" id="productPageSizes">
                    @foreach($product->sizes_list as $index => $size)
                        <button type="button" class="size-btn-choice {{ $index === 0 ? 'active' : '' }}" onclick="selectPageSize('{{ $size }}', this)">
                            {{ $size }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Actions -->
            <div class="actions-row">
                <button type="button" class="btn-buy-now" onclick="addCurrentPageProductToCart()">
                    <i data-lucide="shopping-bag"></i>
                    <span>Add to Bag</span>
                </button>
                <button type="button" id="productPageWhatsAppBtn" onclick="openProductWhatsApp()" class="btn-whatsapp-inquire" style="border: none; cursor: pointer;">
                    <i data-lucide="message-circle"></i>
                    <span>Order on WhatsApp</span>
                </button>
            </div>

            <!-- Perks -->
            <div style="margin-top: 36px; padding: 20px; background: #ffffff; border-radius: var(--radius-sm); border: 1px solid var(--border-color); display: flex; flex-direction: column; gap: 12px; font-size: 13px;">
                <div style="display: flex; gap: 10px; align-items: center;">
                    <i data-lucide="truck" style="color: var(--primary-dark); width: 18px;"></i>
                    <span><strong>Nationwide Ghana Dispatch:</strong> Same-day in Accra, 24-48h other regions.</span>
                </div>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <i data-lucide="store" style="color: var(--primary-dark); width: 18px;"></i>
                    <span><strong>Madina Estate Pickup:</strong> Ready within 2 hours for walk-in collection.</span>
                </div>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <i data-lucide="repeat" style="color: var(--primary-dark); width: 18px;"></i>
                    <span><strong>Easy Exchanges:</strong> Fitting support & size exchanges available.</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let chosenSize = '{{ $product->sizes_list[0] ?? "Standard" }}';
    const productName = '{{ addslashes($product->name) }}';

    function selectPageSize(size, btn) {
        chosenSize = size;
        document.querySelectorAll('#productPageSizes button').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    }

    function openProductWhatsApp() {
        const prod = {
            id: {{ $product->id }},
            name: '{{ addslashes($product->name) }}',
            price: {{ (float) $product->price }},
            size: chosenSize
        };
        openWhatsAppStylist(prod);
    }

    function addCurrentPageProductToCart() {
        const prod = {
            id: {{ $product->id }},
            name: '{{ addslashes($product->name) }}',
            price: {{ (float) $product->price }},
            image_url: '{{ $product->image_url }}',
            sizes: @json($product->sizes_list)
        };
        addToCart(prod, chosenSize, 1);
    }
</script>
@endpush
