@extends('store.layouts.app')

@section('title', 'Order Received — Curves & Tees #' . $order->order_number)

@push('styles')
<style>
    .success-wrapper {
        max-width: 780px;
        margin: 60px auto 100px;
        padding: 0 24px;
        text-align: center;
    }
    .success-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        padding: 48px 36px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-soft);
        text-align: left;
    }
    .success-icon-badge {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: #e8faee;
        color: #25D366;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    .success-card-header {
        text-align: center;
        margin-bottom: 32px;
    }
    .success-card-header h1 {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 34px;
        margin-bottom: 8px;
    }
    .order-ref-pill {
        display: inline-block;
        background: var(--primary-light);
        color: var(--primary-dark);
        font-weight: 800;
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 13px;
        letter-spacing: 0.5px;
    }

    .whatsapp-dispatch-card {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: var(--radius-md);
        padding: 24px;
        margin-bottom: 32px;
        text-align: center;
    }
    .btn-whatsapp-big {
        background: #25D366;
        color: #ffffff;
        padding: 16px 32px;
        border-radius: 50px;
        font-size: 16px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 8px 25px rgba(37, 211, 102, 0.35);
        transition: all 0.2s;
        margin-top: 14px;
    }
    .btn-whatsapp-big:hover {
        background: #1eb855;
        transform: translateY(-2px);
    }

    .order-breakdown {
        border-top: 1px solid var(--border-color);
        padding-top: 24px;
        margin-top: 24px;
    }
    .order-breakdown h4 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 20px;
        margin-bottom: 14px;
    }
    .order-item-line {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        padding: 10px 0;
        border-bottom: 1px dashed #f0eae1;
    }
    .order-total-line {
        display: flex;
        justify-content: space-between;
        font-size: 18px;
        font-weight: 800;
        padding-top: 14px;
        margin-top: 10px;
        color: var(--text-main);
    }

    .delivery-summary {
        background: #faf8f5;
        border-radius: var(--radius-sm);
        padding: 18px;
        margin-top: 24px;
        font-size: 13px;
        line-height: 1.6;
    }
</style>
@endpush

@section('content')
<div class="success-wrapper">
    <div class="success-card">
        <div class="success-icon-badge">
            <i data-lucide="check" style="width: 38px; height: 38px; stroke-width: 2.5;"></i>
        </div>

        <div class="success-card-header">
            <div class="order-ref-pill">Order #{{ $order->order_number }}</div>
            <h1 style="margin-top: 12px;">Thank You, {{ $order->deliveryInformation?->recipient_name }}!</h1>
            <p style="color: var(--text-muted); font-size: 14px;">
                Your order has been recorded into our store system and assigned to our dispatch desk in Madina Estate.
            </p>
        </div>

        <!-- WhatsApp Instant Action -->
        <div class="whatsapp-dispatch-card">
            <h3 class="serif" style="font-size: 22px; margin-bottom: 6px; color: #166534;">Confirm Instantly via WhatsApp</h3>
            <p style="font-size: 13px; color: #15803d; max-width: 500px; margin: 0 auto;">
                Click below to send your item details and delivery address directly to our WhatsApp hotline (<strong>+233 57 103 8444</strong>) so we can pack your pieces immediately.
            </p>
            <a href="{{ $whatsappUrl }}" target="_blank" class="btn-whatsapp-big">
                <i data-lucide="message-circle" style="width: 22px; height: 22px;"></i>
                <span>Open Order in WhatsApp</span>
            </a>
        </div>

        <!-- Items Ordered -->
        <div class="order-breakdown">
            <h4>Items in Your Package</h4>
            @foreach($order->items as $item)
                <div class="order-item-line">
                    <div>
                        <strong>{{ $item->product_name }}</strong>
                        @if($item->size)
                            <span style="color: var(--primary-dark); font-size: 12px; margin-left: 6px;">(Size: {{ $item->size }})</span>
                        @endif
                        <span style="color: var(--text-muted); font-size: 12px;"> × {{ $item->quantity }}</span>
                    </div>
                    <div>GH₵ {{ number_format((float) $item->total, 2) }}</div>
                </div>
            @endforeach

            <div class="order-item-line" style="color: var(--text-muted);">
                <span>Subtotal</span>
                <span>GH₵ {{ number_format((float) $order->subtotal, 2) }}</span>
            </div>

            <div class="order-item-line" style="color: var(--text-muted);">
                <span>Delivery</span>
                <span style="color: #25D366; font-weight: 600;">Standard / Madina</span>
            </div>

            <div class="order-total-line">
                <span>Grand Total</span>
                <span>GH₵ {{ number_format((float) $order->total, 2) }}</span>
            </div>
        </div>

        <!-- Delivery Address Details -->
        <div class="delivery-summary">
            <strong>🚚 Delivery Details:</strong><br>
            <strong>Recipient:</strong> {{ $order->deliveryInformation?->recipient_name }} ({{ $order->deliveryInformation?->phone }})<br>
            <strong>Address:</strong> {{ $order->deliveryInformation?->address }}, {{ $order->deliveryInformation?->city }}<br>
            @if(!empty($order->deliveryInformation?->additional_notes))
                <strong>Notes:</strong> {{ $order->deliveryInformation?->additional_notes }}<br>
            @endif
            <strong>Payment Status:</strong> {{ $order->payment_status }}
        </div>

        <div style="display: flex; gap: 14px; margin-top: 32px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('store.index') }}" class="btn-checkout-primary" style="display: inline-flex; width: auto; padding: 12px 28px; margin-top: 0;">
                <i data-lucide="shopping-bag"></i>
                <span>Continue Shopping</span>
            </a>
            <a href="https://wa.me/233571038444" target="_blank" class="btn-whatsapp-nav" style="border-radius: var(--radius-sm); padding: 12px 24px;">
                <i data-lucide="help-circle"></i>
                <span>Store Support</span>
            </a>
        </div>
    </div>
</div>
@endsection
