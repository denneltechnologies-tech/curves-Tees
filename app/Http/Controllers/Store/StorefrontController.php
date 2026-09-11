<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DeliveryInformation;
use App\Models\HeroSetting;
use App\Models\HeroSlide;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Services\PaystackService;
use App\Services\WhatsAppService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    public function __construct(
        protected WhatsAppService $whatsAppService,
        protected PaystackService $paystackService
    ) {}

    /**
     * Display the main Curves & Tees catalog storefront.
     */
    public function index(Request $request): View
    {
        $categories = Category::where('status', Category::STATUS_ACTIVE)
            ->withCount(['products' => fn($q) => $q->where('status', Product::STATUS_ACTIVE)])
            ->get();

        $query = Product::where('status', Product::STATUS_ACTIVE)->with('category');

        $activeCategory = null;
        if ($request->filled('category')) {
            $catId = $request->get('category');
            $query->where('category_id', $catId);
            $activeCategory = $categories->firstWhere('id', $catId);
        }

        $search = $request->get('search');
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name_asc' => $query->orderBy('name', 'asc'),
            default => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        $featuredProducts = Product::where('status', Product::STATUS_ACTIVE)
            ->where('is_featured', true)
            ->with('category')
            ->take(4)
            ->get();

        $heroSlides = HeroSlide::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        $heroSettings = [
            'hero_badge' => HeroSetting::get('hero_badge', 'NEW COLLECTION • READY-TO-WEAR'),
            'hero_title' => HeroSetting::get('hero_title', "Accra's Premier Destination for *Curve-Flattering* Luxury"),
            'hero_subtitle' => HeroSetting::get('hero_subtitle', 'Celebrating every curve with sculpted corporate wear, radiant evening silhouettes, luxury party dresses, and signature essentials.'),
            'hero_video_url' => HeroSetting::get('hero_video_url', 'https://assets.mixkit.co/videos/preview/mixkit-fashion-model-in-a-photoshoot-wearing-a-red-dress-34440-large.mp4'),
            'hero_video_title' => HeroSetting::get('hero_video_title', 'Curves & Tees • Runway Lookbook'),
            'hero_video_caption' => HeroSetting::get('hero_video_caption', 'Editorial highlights from our latest Accra ready-to-wear showroom release.'),
            'hero_mode' => HeroSetting::get('hero_mode', 'both'),
        ];

        return view('store.index', compact('categories', 'products', 'featuredProducts', 'activeCategory', 'search', 'sort', 'heroSlides', 'heroSettings'));
    }

    /**
     * Get product details as JSON (for modal/quick view) or view.
     */
    public function show(Product $product, Request $request)
    {
        $product->load('category');

        if ($request->wantsJson()) {
            return response()->json([
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => (float) $product->price,
                'price_formatted' => 'GH₵ ' . number_format((float) $product->price, 2),
                'image_url' => $product->image_url,
                'sizes' => $product->sizes_list,
                'category' => $product->category?->name,
                'whatsapp_inquiry_url' => $this->whatsAppService->getProductInquiryUrl($product->name),
            ]);
        }

        $relatedProducts = Product::where('status', Product::STATUS_ACTIVE)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('store.product', compact('product', 'relatedProducts'));
    }

    /**
     * Show dedicated checkout page.
     */
    public function checkoutView(): View
    {
        return view('store.checkout');
    }

    /**
     * Process checkout submission from web storefront.
     */
    public function checkout(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'recipient_name' => ['required', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:25'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'additional_notes' => ['nullable', 'string', 'max:500'],
            'payment_method' => ['required', 'in:whatsapp,paystack,cash_on_delivery'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:20'],
            'items.*.size' => ['nullable', 'string', 'max:50'],
        ]);

        $itemInputs = collect($validated['items']);
        $productIds = $itemInputs->pluck('product_id')->unique();
        $products = Product::whereIn('id', $productIds)->where('status', Product::STATUS_ACTIVE)->get()->keyBy('id');

        if ($products->count() !== $productIds->count()) {
            $msg = 'One or more items in your cart is currently unavailable.';
            return $request->wantsJson()
                ? response()->json(['success' => false, 'message' => $msg], 422)
                : back()->withErrors(['cart' => $msg]);
        }

        $subtotal = 0;
        $orderItemsData = [];

        foreach ($itemInputs as $itemInput) {
            $product = $products->get($itemInput['product_id']);
            $qty = (int) $itemInput['quantity'];
            $price = (float) $product->price;
            $itemTotal = $price * $qty;
            $subtotal += $itemTotal;

            $orderItemsData[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'size' => $itemInput['size'] ?? null,
                'quantity' => $qty,
                'unit_price' => $price,
                'total' => $itemTotal,
            ];
        }

        $deliveryFee = 0; // Can be adjusted or calculated based on area
        $total = $subtotal + $deliveryFee;

        // Ensure customer is saved in the system across all checkouts
        $phone = trim($validated['phone']);
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        $userId = auth()->id();
        $user = null;

        if ($userId) {
            $user = User::find($userId);
        } else {
            $user = User::where('role', User::ROLE_CUSTOMER)
                ->where(function ($q) use ($phone, $cleanPhone) {
                    $q->where('phone', $phone)->orWhere('phone', $cleanPhone);
                })->first();
        }

        $firstSize = collect($orderItemsData)->pluck('size')->filter()->first();

        if (!$user) {
            $slug = Str::slug($validated['recipient_name'], '_') ?: 'customer';
            $uniqueSuffix = substr($cleanPhone, -4) ?: Str::random(4);
            $email = 'customer_' . $slug . '_' . $uniqueSuffix . '@curvesandtees.com';
            if (User::where('email', $email)->exists()) {
                $email = 'customer_' . Str::random(8) . '@curvesandtees.com';
            }

            $user = User::create([
                'name' => $validated['recipient_name'],
                'phone' => $phone,
                'email' => $email,
                'password' => \Illuminate\Support\Facades\Hash::make(Str::random(16)),
                'role' => User::ROLE_CUSTOMER,
                'status' => User::STATUS_ACTIVE,
                'preferred_size' => $firstSize,
                'address' => $validated['address'],
                'city' => $validated['city'] ?? 'Madina / Accra',
                'notes' => $validated['additional_notes'] ?? null,
            ]);
        } else {
            if (empty($user->address) && !empty($validated['address'])) {
                $user->address = $validated['address'];
            }
            if (empty($user->city) && !empty($validated['city'])) {
                $user->city = $validated['city'];
            }
            if (empty($user->preferred_size) && !empty($firstSize)) {
                $user->preferred_size = $firstSize;
            }
            $user->save();
        }

        $userId = $user->id;

        $order = Order::create([
            'user_id' => $userId,
            'order_number' => self::generateOrderNumber(),
            'subtotal' => $subtotal,
            'delivery_fee' => $deliveryFee,
            'total' => $total,
            'payment_status' => Order::PAYMENT_STATUS_PENDING,
            'order_status' => Order::ORDER_STATUS_PENDING,
        ]);

        foreach ($orderItemsData as $itemRow) {
            $itemRow['order_id'] = $order->id;
            OrderItem::create($itemRow);
        }

        DeliveryInformation::create([
            'order_id' => $order->id,
            'recipient_name' => $validated['recipient_name'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'city' => $validated['city'] ?? 'Madina / Accra',
            'additional_notes' => $validated['additional_notes'] ?? null,
        ]);

        $order->load(['items', 'deliveryInformation']);
        $whatsappUrl = $this->whatsAppService->getOrderUrl($order);

        // Record customer lead for marketing campaigns and link to customer
        try {
            $firstItem = $order->items->first();
            \App\Models\CustomerLead::create([
                'name' => $validated['recipient_name'],
                'phone' => trim($validated['phone']),
                'action_type' => \App\Models\CustomerLead::ACTION_CHECKOUT,
                'product_id' => $firstItem?->product_id,
                'product_name' => $order->items->pluck('product_name')->implode(', '),
                'product_price' => $order->total,
                'selected_size' => $order->items->pluck('size')->filter()->implode(', '),
                'cart_data' => $order->items->toArray(),
                'order_id' => $order->id,
                'user_id' => $userId,
                'notes' => 'Checkout via ' . ($validated['payment_method'] ?? 'checkout') . (!empty($validated['additional_notes']) ? ' | ' . $validated['additional_notes'] : ''),
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
            ]);
        } catch (\Throwable $e) {
            if (app()->environment('testing')) {
                throw $e;
            }
            \Illuminate\Support\Facades\Log::warning('CustomerLead create error: ' . $e->getMessage());
        }

        // If customer selected Paystack online payment and Paystack is configured
        $paystackUrl = null;
        if ($validated['payment_method'] === 'paystack') {
            try {
                // Initialize Paystack with dummy or real credentials
                $email = $order->user?->email ?? ('customer_' . Str::slug($order->deliveryInformation->recipient_name, '_') . '@curvesandtees.com');
                $res = $this->paystackService->initializeTransaction(
                    $email,
                    $order->total,
                    route('store.order.success', $order->order_number),
                    [
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                    ]
                );

                if (!empty($res['data']['authorization_url'])) {
                    $paystackUrl = $res['data']['authorization_url'];
                }
            } catch (\Throwable $e) {
                // Fallback gracefully to WhatsApp / confirmation
            }
        }

        $successUrl = route('store.order.success', $order->order_number);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'order_number' => $order->order_number,
                'whatsapp_url' => $whatsappUrl,
                'paystack_url' => $paystackUrl,
                'redirect_url' => $paystackUrl ?: $successUrl,
            ]);
        }

        if ($paystackUrl) {
            return redirect($paystackUrl);
        }

        return redirect($successUrl);
    }

    /**
     * Display order confirmation & WhatsApp redirect page.
     */
    public function orderSuccess(string $orderNumber): View
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['items', 'deliveryInformation'])
            ->firstOrFail();

        $whatsappUrl = $this->whatsAppService->getOrderUrl($order);

        return view('store.success', compact('order', 'whatsappUrl'));
    }

    /**
     * Generate Curves & Tees order number (e.g. CT-849201).
     */
    public static function generateOrderNumber(): string
    {
        do {
            $number = 'CT-' . strtoupper(Str::random(6));
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }
}
