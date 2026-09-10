<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerLead extends Model
{
    use HasFactory;

    public const ACTION_WHATSAPP_INQUIRY = 'whatsapp_inquiry';
    public const ACTION_ADD_TO_CART = 'add_to_cart';
    public const ACTION_CHECKOUT = 'checkout';
    public const ACTION_VIP_CLUB = 'vip_club';
    public const ACTION_ADMIN_DIRECT = 'admin_direct';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'action_type',
        'product_id',
        'product_name',
        'product_price',
        'selected_size',
        'cart_data',
        'order_id',
        'user_id',
        'notes',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'cart_data' => 'array',
        'product_price' => 'decimal:2',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get international WhatsApp formatted phone (Ghana 233 default).
     */
    public function getWhatsAppNumber(): string
    {
        $digits = preg_replace('/[^0-9]/', '', $this->phone);
        if (str_starts_with($digits, '0')) {
            $digits = '233' . substr($digits, 1);
        }
        return $digits;
    }

    /**
     * Generate 1-click WhatsApp follow-up link for this lead.
     */
    public function getWhatsAppFollowupUrl(): string
    {
        $phone = $this->getWhatsAppNumber();
        $greetingName = $this->name ? ' ' . $this->name : '';
        $outfit = $this->product_name ?: 'our latest Curves & Tees collections';
        $sizeText = $this->selected_size ? ' in ' . $this->selected_size : '';

        $text = "Hello{$greetingName}! 💖 This is Curves & Tees boutique in Madina Estate. We noticed your interest in our {$outfit}{$sizeText}. Can our stylist assist you with sizing or reserving your order today?";

        return 'https://wa.me/' . $phone . '?text=' . rawurlencode($text);
    }
}
