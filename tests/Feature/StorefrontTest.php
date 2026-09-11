<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorefrontTest extends TestCase
{
    use RefreshDatabase;

    public function test_storefront_home_loads_successfully(): void
    {
        $category = Category::create(['name' => 'Corporate Wears', 'status' => 'active']);
        Product::create([
            'category_id' => $category->id,
            'name' => 'Ribbed Midi Dress',
            'price' => 220.00,
            'status' => 'active',
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Curves & Tees');
        $response->assertSee('Ribbed Midi Dress');
        $response->assertSee('Corporate Wears');
        // Ensure Admin Portal is removed from footer
        $response->assertDontSee('Admin Portal');
        $response->assertDontSee('Admin Dashboard');
    }

    public function test_product_detail_page_loads(): void
    {
        $product = Product::create([
            'name' => 'Satin Wrap Maxi Dress',
            'price' => 320.00,
            'sizes' => 'UK 12, UK 14, UK 16',
            'status' => 'active',
        ]);

        $response = $this->get("/product/{$product->id}");
        $response->assertStatus(200);
        $response->assertSee('Satin Wrap Maxi Dress');
        $response->assertSee('GH₵ 320.00');
    }

    public function test_guest_checkout_creates_order_and_generates_whatsapp_url(): void
    {
        $product = Product::create([
            'name' => 'Plisse Two-Piece Set',
            'price' => 310.00,
            'status' => 'active',
        ]);

        $payload = [
            'recipient_name' => 'Ama Osei',
            'phone' => '0571038444',
            'address' => 'Madina Estate House 12',
            'city' => 'Accra',
            'payment_method' => 'whatsapp',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'size' => 'UK 16',
                ],
            ],
        ];

        $response = $this->postJson('/checkout', $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $order = Order::latest()->first();
        $this->assertNotNull($order);
        $this->assertEquals(310.00, (float) $order->total);
        $this->assertEquals('Ama Osei', $order->deliveryInformation->recipient_name);
        $this->assertStringContainsString('https://wa.me/233571038444', $response->json('whatsapp_url'));
    }
}
