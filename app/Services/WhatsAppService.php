<?php

namespace App\Services;

use App\Models\Order;

class WhatsAppService
{
    /**
     * Curves & Tees official store WhatsApp number.
     * International format without '+' (233571038444).
     */
    protected string $phone;

    public function __construct()
    {
        $this->phone = config('services.whatsapp.store_phone', '233571038444');
    }

    /**
     * Generate pre-formatted message for an order.
     */
    public function generateOrderMessage(Order $order): string
    {
        $delivery = $order->deliveryInformation;

        $lines = [];
        $lines[] = "✨ *NEW ORDER — CURVES & TEES* ✨";
        $lines[] = "Order Ref: *#{$order->order_number}*";
        $lines[] = "Date: " . $order->created_at->format('d M Y, h:i A');
        $lines[] = "--------------------------------";
        $lines[] = "👤 *CUSTOMER DETAILS:*";
        $lines[] = "• Name: " . ($delivery->recipient_name ?? 'Valued Customer');
        $lines[] = "• Phone: " . ($delivery->phone ?? 'N/A');
        $lines[] = "• Address: " . ($delivery->address ?? 'Pick up / To be confirmed');
        if (!empty($delivery->city)) {
            $lines[] = "• City/Area: " . $delivery->city;
        }
        if (!empty($delivery->additional_notes)) {
            $lines[] = "• Notes: " . $delivery->additional_notes;
        }
        $lines[] = "--------------------------------";
        $lines[] = "🛍️ *ITEMS ORDERED:*";

        foreach ($order->items as $item) {
            $sizeStr = !empty($item->size) ? " (Size: {$item->size})" : "";
            $itemTotal = number_format((float) $item->total, 2);
            $lines[] = "• {$item->quantity}x {$item->product_name}{$sizeStr} — GH₵ {$itemTotal}";
        }

        $lines[] = "--------------------------------";
        $lines[] = "💰 *Subtotal:* GH₵ " . number_format((float) $order->subtotal, 2);
        if ((float) $order->delivery_fee > 0) {
            $lines[] = "🚚 *Delivery Fee:* GH₵ " . number_format((float) $order->delivery_fee, 2);
        } else {
            $lines[] = "🚚 *Delivery:* To be calculated / Free pickup at Madina Estate";
        }
        $lines[] = "🏷️ *TOTAL:* *GH₵ " . number_format((float) $order->total, 2) . "*";
        $lines[] = "💳 *Payment:* " . ($order->payment_status === Order::PAYMENT_STATUS_SUCCESSFUL ? 'Paid Online ✅' : 'Pay on Delivery / MoMo on Delivery ⏳');
        $lines[] = "--------------------------------";
        $lines[] = "Please confirm availability and dispatch details. Thank you! 💖";

        return implode("\n", $lines);
    }

    /**
     * Generate the clickable WhatsApp chat URL.
     */
    public function getOrderUrl(Order $order): string
    {
        $message = $this->generateOrderMessage($order);
        return "https://wa.me/{$this->phone}?text=" . rawurlencode($message);
    }

    /**
     * Generate quick inquiry WhatsApp URL for a specific product.
     */
    public function getProductInquiryUrl(string $productName, ?string $size = null): string
    {
        $text = "Hello Curves & Tees! 💖 I am interested in ordering the *{$productName}*";
        if ($size) {
            $text .= " in size *{$size}*";
        }
        $text .= ". Is this available?";

        return "https://wa.me/{$this->phone}?text=" . rawurlencode($text);
    }
}
