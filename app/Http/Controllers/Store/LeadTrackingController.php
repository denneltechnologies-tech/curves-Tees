<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\CustomerLead;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LeadTrackingController extends Controller
{
    /**
     * Record or update a customer lead from WhatsApp inquiry, cart, or VIP signup,
     * and ensure customer profile is saved in the system.
     */
    public function track(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:30'],
            'name' => ['nullable', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:120'],
            'action_type' => ['nullable', 'string', 'max:50'],
            'product_id' => ['nullable', 'integer'],
            'product_name' => ['nullable', 'string', 'max:255'],
            'product_price' => ['nullable', 'numeric'],
            'selected_size' => ['nullable', 'string', 'max:50'],
            'cart_data' => ['nullable'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $productId = $validated['product_id'] ?? null;
        $productName = $validated['product_name'] ?? null;
        $productPrice = $validated['product_price'] ?? null;

        if ($productId && (!$productName || !$productPrice)) {
            $product = Product::find($productId);
            if ($product) {
                $productName = $productName ?: $product->name;
                $productPrice = $productPrice ?: $product->price;
            }
        }

        $phone = trim($validated['phone']);
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        $name = !empty($validated['name']) ? trim($validated['name']) : null;

        // Ensure customer exists in the system
        $user = User::where('role', User::ROLE_CUSTOMER)
            ->where(function ($q) use ($phone, $cleanPhone) {
                $q->where('phone', $phone)->orWhere('phone', $cleanPhone);
            })->first();

        if (!$user && $name) {
            $slug = Str::slug($name, '_') ?: 'lead';
            $uniqueSuffix = substr($cleanPhone, -4) ?: Str::random(4);
            $email = !empty($validated['email'])
                ? $validated['email']
                : ('customer_' . $slug . '_' . $uniqueSuffix . '@curvesandtees.com');

            if (User::where('email', $email)->exists()) {
                $email = 'customer_' . Str::random(8) . '@curvesandtees.com';
            }

            $user = User::create([
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
                'password' => Hash::make(Str::random(16)),
                'role' => User::ROLE_CUSTOMER,
                'status' => User::STATUS_ACTIVE,
                'preferred_size' => $validated['selected_size'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);
        } elseif ($user) {
            $dirty = false;
            if ($name && (empty($user->name) || $user->name === 'Valued Customer')) {
                $user->name = $name;
                $dirty = true;
            }
            if (!empty($validated['selected_size']) && empty($user->preferred_size)) {
                $user->preferred_size = $validated['selected_size'];
                $dirty = true;
            }
            if ($dirty) {
                $user->save();
            }
        }

        $lead = CustomerLead::create([
            'name' => $name ?: $user?->name,
            'phone' => $phone,
            'email' => $validated['email'] ?? $user?->email,
            'action_type' => $validated['action_type'] ?? CustomerLead::ACTION_WHATSAPP_INQUIRY,
            'product_id' => $productId,
            'product_name' => $productName,
            'product_price' => $productPrice,
            'selected_size' => $validated['selected_size'] ?? $user?->preferred_size,
            'cart_data' => $validated['cart_data'] ?? null,
            'user_id' => $user?->id,
            'notes' => $validated['notes'] ?? null,
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 500),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Lead and customer captured successfully',
            'lead_id' => $lead->id,
            'customer_id' => $user?->id,
        ]);
    }
}
