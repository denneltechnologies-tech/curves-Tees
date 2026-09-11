<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_storekeeper_can_access_orders_and_products_management(): void
    {
        $storekeeper = User::factory()->create([
            'role' => User::ROLE_STOREKEEPER,
            'status' => User::STATUS_ACTIVE,
        ]);

        $this->actingAs($storekeeper)->get(route('admin.dashboard'))->assertOk();
        $this->actingAs($storekeeper)->get(route('admin.orders.index'))->assertOk();
        $this->actingAs($storekeeper)->get(route('admin.products.index'))->assertOk();
        $this->actingAs($storekeeper)->get(route('admin.categories.index'))->assertOk();
    }

    public function test_storekeeper_cannot_access_user_management(): void
    {
        $storekeeper = User::factory()->create([
            'role' => User::ROLE_STOREKEEPER,
            'status' => User::STATUS_ACTIVE,
        ]);

        $response = $this->actingAs($storekeeper)->get(route('admin.users.index'));
        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('error');
    }

    public function test_storekeeper_cannot_access_hero_management(): void
    {
        $storekeeper = User::factory()->create([
            'role' => User::ROLE_STOREKEEPER,
            'status' => User::STATUS_ACTIVE,
        ]);

        $response = $this->actingAs($storekeeper)->get(route('admin.hero.index'));
        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('error');
    }

    public function test_storekeeper_cannot_access_leads_management(): void
    {
        $storekeeper = User::factory()->create([
            'role' => User::ROLE_STOREKEEPER,
            'status' => User::STATUS_ACTIVE,
        ]);

        $response = $this->actingAs($storekeeper)->get(route('admin.leads.index'));
        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('error');
    }

    public function test_storekeeper_cannot_delete_products(): void
    {
        $storekeeper = User::factory()->create([
            'role' => User::ROLE_STOREKEEPER,
            'status' => User::STATUS_ACTIVE,
        ]);

        $category = Category::create([
            'name' => 'Test Collection',
            'slug' => 'test-collection',
            'status' => Category::STATUS_ACTIVE,
        ]);

        $product = Product::create([
            'name' => 'Sample Dress',
            'slug' => 'sample-dress',
            'price' => 200,
            'category_id' => $category->id,
            'status' => Product::STATUS_ACTIVE,
        ]);

        $response = $this->actingAs($storekeeper)->delete(route('admin.products.destroy', $product));
        $response->assertRedirect(route('admin.dashboard'));
        $this->assertDatabaseHas('products', ['id' => $product->id]);
    }

    public function test_full_admin_has_complete_access(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ]);

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
        $this->actingAs($admin)->get(route('admin.orders.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.products.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.hero.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.users.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.leads.index'))->assertOk();
    }
}
