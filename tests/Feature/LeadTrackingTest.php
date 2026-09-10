<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\CustomerLead;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeadTrackingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'CategorySeeder']);
        $this->artisan('db:seed', ['--class' => 'ProductSeeder']);
        $this->artisan('db:seed', ['--class' => 'AdminUserSeeder']);
    }

    public function test_can_track_whatsapp_inquiry_lead(): void
    {
        $product = Product::first();

        $response = $this->postJson('/store/leads/track', [
            'phone' => '0541234567',
            'name' => 'Adjoa Mansa',
            'action_type' => 'whatsapp_inquiry',
            'product_id' => $product->id,
            'selected_size' => 'UK 14',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('customer_leads', [
            'phone' => '0541234567',
            'name' => 'Adjoa Mansa',
            'action_type' => 'whatsapp_inquiry',
            'product_id' => $product->id,
            'selected_size' => 'UK 14',
        ]);
    }

    public function test_checkout_automatically_records_customer_lead(): void
    {
        $product = Product::first();

        $response = $this->post('/checkout', [
            'recipient_name' => 'Ama Serwaa',
            'phone' => '0571122334',
            'address' => 'Madina Estate Block 4',
            'city' => 'Madina',
            'payment_method' => 'whatsapp',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'size' => 'UK 16',
                ],
            ],
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('customer_leads', [
            'phone' => '0571122334',
            'name' => 'Ama Serwaa',
            'action_type' => 'checkout',
        ]);
    }

    public function test_admin_can_view_leads_dashboard_and_export_csv(): void
    {
        $admin = User::where('role', User::ROLE_SUPER_ADMIN)->first();

        CustomerLead::create([
            'phone' => '0541112233',
            'name' => 'Efua Darko',
            'action_type' => 'whatsapp_inquiry',
            'product_name' => 'Ribbed Bodycon Dress',
            'product_price' => 240.00,
            'selected_size' => 'UK 14',
        ]);

        $response = $this->actingAs($admin)->get('/admin/leads');
        $response->assertStatus(200);
        $response->assertSee('Efua Darko');
        $response->assertSee('0541112233');

        $exportResponse = $this->actingAs($admin)->get('/admin/leads/export');
        $exportResponse->assertStatus(200);
        $exportResponse->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }

    public function test_can_save_customer_directly_from_admin_and_log_lead(): void
    {
        $admin = User::where('role', User::ROLE_SUPER_ADMIN)->first();

        $response = $this->actingAs($admin)->post('/admin/customers', [
            'name' => 'Akosua Mensah',
            'phone' => '0244123987',
            'email' => 'akosua@example.com',
            'preferred_size' => 'UK 18',
            'address' => 'Madina Showroom walk-in',
            'city' => 'Madina / Accra',
            'source' => 'In-Store Walk-in / Showroom',
            'outfit_interest' => 'Satin Wrap Dress',
            'notes' => 'Loves vibrant floral patterns',
            'status' => 'active',
        ]);

        $response->assertStatus(302);

        // Verify customer created in users table
        $customer = User::where('phone', '0244123987')->first();
        $this->assertNotNull($customer);
        $this->assertEquals('Akosua Mensah', $customer->name);
        $this->assertEquals('UK 18', $customer->preferred_size);
        $this->assertEquals(User::ROLE_CUSTOMER, $customer->role);

        // Verify activity logged in customer_leads table
        $this->assertDatabaseHas('customer_leads', [
            'phone' => '0244123987',
            'name' => 'Akosua Mensah',
            'action_type' => CustomerLead::ACTION_ADMIN_DIRECT,
            'selected_size' => 'UK 18',
            'user_id' => $customer->id,
        ]);
    }

    public function test_admin_can_update_customer_profile(): void
    {
        $admin = User::where('role', User::ROLE_SUPER_ADMIN)->first();

        $customer = User::create([
            'name' => 'Esi Badu',
            'phone' => '0555001122',
            'email' => 'esi@example.com',
            'password' => bcrypt('secret123'),
            'role' => User::ROLE_CUSTOMER,
            'preferred_size' => 'UK 12',
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)->put("/admin/customers/{$customer->id}", [
            'name' => 'Esi Badu-Williams',
            'phone' => '0555001122',
            'email' => 'esi.updated@example.com',
            'preferred_size' => 'UK 14',
            'city' => 'East Legon',
            'address' => 'Boundary Road, House 8',
            'notes' => 'Prefers evening deliveries',
            'status' => 'active',
        ]);

        $response->assertStatus(302);

        $customer->refresh();
        $this->assertEquals('Esi Badu-Williams', $customer->name);
        $this->assertEquals('UK 14', $customer->preferred_size);
        $this->assertEquals('East Legon', $customer->city);
    }

    public function test_whatsapp_inquiry_and_checkout_both_save_customer_to_users(): void
    {
        // 1. WhatsApp inquiry creates customer
        $this->postJson('/store/leads/track', [
            'phone' => '0501239999',
            'name' => 'Korkor Tetteh',
            'action_type' => 'whatsapp_inquiry',
            'selected_size' => 'UK 16',
        ])->assertStatus(200);

        $user = User::where('phone', '0501239999')->first();
        $this->assertNotNull($user);
        $this->assertEquals('Korkor Tetteh', $user->name);
        $this->assertEquals('UK 16', $user->preferred_size);
        $this->assertEquals(User::ROLE_CUSTOMER, $user->role);

        // 2. Checkout creates customer if not yet existing
        $product = Product::first();
        $this->post('/checkout', [
            'recipient_name' => 'Yaa Asantewaa',
            'phone' => '0277889900',
            'address' => 'Madina Market, Shop 45',
            'city' => 'Madina',
            'payment_method' => 'whatsapp',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'size' => 'UK 20',
                ],
            ],
        ])->assertStatus(302);

        $checkoutUser = User::where('phone', '0277889900')->first();
        $this->assertNotNull($checkoutUser);
        $this->assertEquals('Yaa Asantewaa', $checkoutUser->name);
        $this->assertEquals('UK 20', $checkoutUser->preferred_size);
        $this->assertEquals(User::ROLE_CUSTOMER, $checkoutUser->role);
    }
}
