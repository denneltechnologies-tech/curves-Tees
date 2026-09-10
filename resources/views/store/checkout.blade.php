@extends('store.layouts.app')

@section('title', 'Checkout — Curves & Tees')

@push('styles')
<style>
    .checkout-wrapper {
        max-width: 1180px;
        margin: 50px auto 80px;
        padding: 0 24px;
    }
    .checkout-title {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 38px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    .checkout-subtitle {
        color: var(--text-muted);
        font-size: 14px;
        margin-bottom: 36px;
    }

    .checkout-grid {
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 40px;
        align-items: start;
    }
    @media (max-width: 900px) {
        .checkout-grid { grid-template-columns: 1fr; }
    }

    .form-card {
        background: #ffffff;
        border-radius: var(--radius-md);
        padding: 32px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-soft);
    }
    .form-card h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 24px;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f0eae1;
    }

    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 6px;
        color: var(--text-main);
    }
    .form-control {
        width: 100%;
        padding: 12px 16px;
        border-radius: var(--radius-sm);
        border: 1px solid var(--border-color);
        font-family: inherit;
        font-size: 14px;
        background: #faf8f5;
        color: var(--text-main);
        outline: none;
        transition: border-color 0.2s;
    }
    .form-control:focus {
        border-color: var(--primary-dark);
        background: #ffffff;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    @media (max-width: 600px) {
        .form-row { grid-template-columns: 1fr; }
    }

    /* Payment Radio Cards */
    .payment-option-card {
        border: 1px solid var(--border-color);
        border-radius: var(--radius-sm);
        padding: 16px;
        margin-bottom: 12px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        cursor: pointer;
        transition: all 0.2s;
        background: #faf8f5;
    }
    .payment-option-card:hover {
        border-color: #cfc5b8;
    }
    .payment-option-card.active {
        border-color: var(--primary-dark);
        background: #fff8f2;
    }
    .payment-option-card input[type="radio"] {
        margin-top: 3px;
        accent-color: var(--primary-dark);
    }

    /* Order Summary Card */
    .summary-card {
        background: #ffffff;
        border-radius: var(--radius-md);
        padding: 30px;
        border: 1px solid var(--border-color);
        position: sticky;
        top: 90px;
        box-shadow: var(--shadow-soft);
    }
    .summary-card h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 24px;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f0eae1;
    }
    .summary-items-list {
        max-height: 280px;
        overflow-y: auto;
        margin-bottom: 20px;
    }
    .summary-item-row {
        display: flex;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #f5ede4;
        font-size: 13px;
    }
    .summary-item-thumb {
        width: 50px;
        height: 60px;
        border-radius: 6px;
        object-fit: cover;
        background: #eee;
    }
    .summary-totals-row {
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        margin-bottom: 10px;
        color: var(--text-muted);
    }
    .summary-totals-row.grand-total {
        font-size: 18px;
        font-weight: 800;
        color: var(--text-main);
        padding-top: 14px;
        border-top: 1px solid var(--border-color);
        margin-top: 10px;
    }
</style>
@endpush

@section('content')
<div class="checkout-wrapper">
    <div class="checkout-header">
        <h1 class="checkout-title">Complete Your Order</h1>
        <p class="checkout-subtitle">Enter your delivery information below to send your order directly to our kitchen & staff.</p>
    </div>

    <!-- Empty cart notice -->
    <div id="checkoutEmptyWarning" style="display: none; text-align: center; padding: 60px 20px; background: #fff; border-radius: var(--radius-md); border: 1px dashed var(--border-color);">
        <i data-lucide="shopping-bag" style="width: 48px; height: 48px; color: var(--text-muted); margin-bottom: 12px;"></i>
        <h3 class="serif" style="font-size: 24px; margin-bottom: 8px;">Your Shopping Bag is Empty</h3>
        <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 24px;">Please select outfits from our catalog before checking out.</p>
        <a href="{{ route('store.index') }}" class="btn-hero-primary" style="display: inline-flex;">
            Explore Catalog
        </a>
    </div>

    <div class="checkout-grid" id="checkoutGrid">
        <!-- Form Details -->
        <div class="form-card">
            <h3>1. Delivery Information</h3>
            <form id="checkoutForm" onsubmit="handleCheckoutSubmit(event)">
                @csrf

                <div class="form-group">
                    <label for="recipient_name">Full Name *</label>
                    <input type="text" id="recipient_name" name="recipient_name" class="form-control" required placeholder="e.g., Ama Mensah">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">WhatsApp / Phone Number *</label>
                        <input type="tel" id="phone" name="phone" class="form-control" required placeholder="e.g., 057 103 8444">
                    </div>
                    <div class="form-group">
                        <label for="city">Town / City / Area *</label>
                        <input type="text" id="city" name="city" class="form-control" required placeholder="e.g., Madina, East Legon, Accra" value="Accra">
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">Delivery Address / Nearest Landmark *</label>
                    <input type="text" id="address" name="address" class="form-control" required placeholder="e.g., Madina Estate, opposite shell station, House #24">
                </div>

                <div class="form-group">
                    <label for="additional_notes">Special Delivery Notes (Optional)</label>
                    <textarea id="additional_notes" name="additional_notes" class="form-control" rows="2" placeholder="e.g., Preferred delivery time, gate instructions"></textarea>
                </div>

                <h3 style="margin-top: 36px;">2. Payment & Confirmation Method</h3>

                <!-- WhatsApp Order Option (Recommended) -->
                <label class="payment-option-card active" id="payOptionWhatsApp" onclick="selectPaymentMethod('whatsapp')">
                    <input type="radio" name="payment_method" value="whatsapp" checked>
                    <div>
                        <strong style="color: #191614; font-size: 14px; display: block;">
                            📱 Send Order via WhatsApp (Recommended)
                        </strong>
                        <span style="font-size: 13px; color: var(--text-muted); display: block; margin-top: 2px;">
                            Instantly opens a pre-filled WhatsApp message with our store (+233 57 103 8444) so our team can confirm availability and dispatch!
                        </span>
                    </div>
                </label>

                <!-- Paystack Option -->
                <label class="payment-option-card" id="payOptionPaystack" onclick="selectPaymentMethod('paystack')">
                    <input type="radio" name="payment_method" value="paystack">
                    <div>
                        <strong style="color: #191614; font-size: 14px; display: block;">
                            💳 Pay Online with Paystack (Mobile Money / Card)
                        </strong>
                        <span style="font-size: 13px; color: var(--text-muted); display: block; margin-top: 2px;">
                            Pay securely with MTN Mobile Money, Telecel Cash, AT Money, or Visa/Mastercard.
                        </span>
                    </div>
                </label>

                <!-- Cash / MoMo on Delivery Option -->
                <label class="payment-option-card" id="payOptionCash" onclick="selectPaymentMethod('cash_on_delivery')">
                    <input type="radio" name="payment_method" value="cash_on_delivery">
                    <div>
                        <strong style="color: #191614; font-size: 14px; display: block;">
                            💵 Pay on Delivery
                        </strong>
                        <span style="font-size: 13px; color: var(--text-muted); display: block; margin-top: 2px;">
                            Pay via Cash or Mobile Money transfer when rider arrives with your package.
                        </span>
                    </div>
                </label>

                <div style="margin-top: 32px;">
                    <button type="submit" class="btn-checkout-primary" id="submitOrderBtn" style="padding: 16px; font-size: 16px;">
                        <i data-lucide="check-circle" id="submitBtnIcon"></i>
                        <span id="submitBtnText">Place Order & Open in WhatsApp</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Summary Column -->
        <div class="summary-card">
            <h3>Order Summary</h3>
            <div class="summary-items-list" id="checkoutItemsList">
                <!-- Dynamic Items from localStorage -->
            </div>

            <div class="summary-totals-row">
                <span>Items Subtotal</span>
                <span id="checkoutSubtotal">GH₵ 0.00</span>
            </div>
            <div class="summary-totals-row">
                <span>Delivery</span>
                <span style="color: #25D366; font-weight: 600;">Standard / Madina</span>
            </div>
            <div class="summary-totals-row grand-total">
                <span>Total Due</span>
                <span id="checkoutTotal">GH₵ 0.00</span>
            </div>

            <div style="background: #faf8f5; border-radius: 8px; padding: 14px; margin-top: 20px; font-size: 12px; color: var(--text-muted); border: 1px solid var(--border-color);">
                <div style="display: flex; gap: 8px; align-items: center; margin-bottom: 4px; font-weight: 700; color: var(--text-main);">
                    <i data-lucide="shield-check" style="width: 16px; height: 16px; color: var(--primary);"></i>
                    <span>Authentic Curves & Tees Guarantee</span>
                </div>
                <span>All items are quality-inspected before dispatch. Free size exchange assistance available within Accra.</span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function renderCheckoutItems() {
        const grid = document.getElementById('checkoutGrid');
        const emptyWarning = document.getElementById('checkoutEmptyWarning');
        const listEl = document.getElementById('checkoutItemsList');
        const subtotalEl = document.getElementById('checkoutSubtotal');
        const totalEl = document.getElementById('checkoutTotal');

        if (!cart || cart.length === 0) {
            if (grid) grid.style.display = 'none';
            if (emptyWarning) emptyWarning.style.display = 'block';
            return;
        }

        if (grid) grid.style.display = 'grid';
        if (emptyWarning) emptyWarning.style.display = 'none';

        let subtotal = 0;
        listEl.innerHTML = cart.map(item => {
            const itemTotal = item.price * item.quantity;
            subtotal += itemTotal;
            return `
                <div class="summary-item-row">
                    <img src="${item.image}" alt="${item.name}" class="summary-item-thumb">
                    <div style="flex: 1; min-width: 0;">
                        <strong style="display: block; font-size: 13px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">${item.name}</strong>
                        <span style="color: var(--primary-dark); font-size: 11px;">Size: ${item.size || 'Standard'} • Qty: ${item.quantity}</span>
                        <div style="font-weight: 700; margin-top: 2px;">GH₵ ${itemTotal.toFixed(2)}</div>
                    </div>
                </div>
            `;
        }).join('');

        if (subtotalEl) subtotalEl.textContent = 'GH₵ ' + subtotal.toFixed(2);
        if (totalEl) totalEl.textContent = 'GH₵ ' + subtotal.toFixed(2);
    }

    function selectPaymentMethod(method) {
        document.querySelectorAll('.payment-option-card').forEach(card => card.classList.remove('active'));
        const activeCard = document.querySelector(`input[name="payment_method"][value="${method}"]`)?.closest('.payment-option-card');
        if (activeCard) activeCard.classList.add('active');

        const btnText = document.getElementById('submitBtnText');
        if (btnText) {
            if (method === 'whatsapp') {
                btnText.textContent = 'Place Order & Open in WhatsApp';
            } else if (method === 'paystack') {
                btnText.textContent = 'Proceed to Paystack Payment';
            } else {
                btnText.textContent = 'Confirm Order (Pay on Delivery)';
            }
        }
    }

    async function handleCheckoutSubmit(e) {
        e.preventDefault();

        if (!cart || cart.length === 0) {
            alert('Your cart is empty.');
            return;
        }

        const btn = document.getElementById('submitOrderBtn');
        const originalText = document.getElementById('submitBtnText').textContent;
        btn.disabled = true;
        document.getElementById('submitBtnText').textContent = 'Processing Order...';

        const form = document.getElementById('checkoutForm');
        const formData = new FormData(form);

        // Append items array
        const payload = {
            recipient_name: formData.get('recipient_name'),
            phone: formData.get('phone'),
            address: formData.get('address'),
            city: formData.get('city'),
            additional_notes: formData.get('additional_notes'),
            payment_method: formData.get('payment_method'),
            items: cart.map(item => ({
                product_id: item.id,
                quantity: item.quantity,
                size: item.size
            }))
        };

        try {
            const res = await fetch('{{ route('store.checkout.submit') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            });

            const data = await res.json();

            if (data.success) {
                // Clear cart locally
                cart = [];
                saveCart();

                // If WhatsApp method selected, open WhatsApp in new tab and navigate to success page
                if (payload.payment_method === 'whatsapp' && data.whatsapp_url) {
                    window.open(data.whatsapp_url, '_blank');
                }

                // Redirect to success or paystack URL
                window.location.href = data.redirect_url;
            } else {
                alert(data.message || 'Unable to place order. Please try again or chat with us on WhatsApp.');
                btn.disabled = false;
                document.getElementById('submitBtnText').textContent = originalText;
            }
        } catch (err) {
            console.error(err);
            alert('An error occurred while placing your order. Please try again.');
            btn.disabled = false;
            document.getElementById('submitBtnText').textContent = originalText;
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderCheckoutItems();
    });
</script>
@endpush
