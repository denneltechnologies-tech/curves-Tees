<?php

namespace Tests\Feature;

use App\Models\HeroSetting;
use App\Models\HeroSlide;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HeroManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_hero_management(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.hero.index'));

        $response->assertStatus(200);
        $response->assertSee('Hero Section & Media Showcase');
    }

    public function test_admin_can_update_hero_settings(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.hero.settings'), [
            'hero_badge' => 'EXCLUSIVE ACCRA COUTURE',
            'hero_title' => "Accra's Finest *Sculpted* Elegance",
            'hero_subtitle' => 'Curated for graceful curves.',
            'hero_video_url' => 'https://example.com/video.mp4',
            'hero_video_title' => 'Curves & Tees Runway',
            'hero_mode' => 'both',
        ]);

        $response->assertRedirect(route('admin.hero.index'));
        $this->assertEquals("Accra's Finest *Sculpted* Elegance", HeroSetting::get('hero_title'));
    }

    public function test_admin_can_create_and_toggle_hero_slide(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'status' => User::STATUS_ACTIVE,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.hero.slides.store'), [
            'title' => 'Autumn Gala Silhouettes',
            'subtitle' => 'Radiant cuts for evening dinners',
            'tag' => 'GALA COLLECTION',
            'image_url' => 'https://example.com/photo.jpg',
            'button_text' => 'Shop Gala',
            'button_link' => '#catalog',
            'sort_order' => 1,
        ]);

        $response->assertRedirect(route('admin.hero.index'));
        $slide = HeroSlide::where('title', 'Autumn Gala Silhouettes')->first();
        $this->assertNotNull($slide);
        $this->assertTrue($slide->is_active);

        // Test toggle
        $toggleResponse = $this->actingAs($admin)->patch(route('admin.hero.slides.toggle', $slide));
        $toggleResponse->assertRedirect(route('admin.hero.index'));
        $this->assertFalse($slide->fresh()->is_active);
    }
}
