<?php

namespace Database\Seeders;

use App\Models\HeroSetting;
use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only seed default settings if not already customized by user
        if (!HeroSetting::where('key', 'hero_title')->exists()) {
            HeroSetting::set('hero_badge', 'NEW COLLECTION • READY-TO-WEAR');
            HeroSetting::set('hero_title', "Accra's Premier Destination for *Curve-Flattering* Luxury");
            HeroSetting::set('hero_subtitle', 'Celebrating every curve with sculpted corporate wear, radiant evening silhouettes, luxury party dresses, and signature essentials.');
            HeroSetting::set('hero_video_url', 'https://assets.mixkit.co/videos/preview/mixkit-fashion-model-in-a-photoshoot-wearing-a-red-dress-34440-large.mp4');
            HeroSetting::set('hero_video_title', 'Curves & Tees • Runway Lookbook');
            HeroSetting::set('hero_video_caption', 'Editorial highlights from our latest Accra ready-to-wear showroom release.');
            HeroSetting::set('hero_mode', 'both');
        }

        // Default Editorial Slides (only if database is empty)
        if (HeroSlide::count() === 0) {
            HeroSlide::create([
                'title' => 'The Accra Luxury Silhouette',
                'subtitle' => 'Sculpted tailoring crafted for confident everyday elegance.',
                'tag' => 'EDITORIAL • SS26',
                'media_type' => 'image',
                'image_path' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=1200&q=80',
                'button_text' => 'Explore Collections',
                'button_link' => '#catalog',
                'sort_order' => 1,
                'is_active' => true,
            ]);

            HeroSlide::create([
                'title' => 'Sensational Evening Gala',
                'subtitle' => 'Floor-sweeping contours and refined party statements.',
                'tag' => 'EVENING DRESSES',
                'media_type' => 'image',
                'image_path' => 'https://images.unsplash.com/photo-1539109136881-3be0616acf4b?auto=format&fit=crop&w=1200&q=80',
                'button_text' => 'Shop Evening Gowns',
                'button_link' => route('store.index', ['category' => 3]),
                'sort_order' => 2,
                'is_active' => true,
            ]);

            HeroSlide::create([
                'title' => 'Signature Corporate Elegance',
                'subtitle' => 'Executive power blazers and chic two-piece coordination.',
                'tag' => 'CORPORATE EDIT',
                'media_type' => 'image',
                'image_path' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=1200&q=80',
                'button_text' => 'View Corporate Wear',
                'button_link' => route('store.index', ['category' => 1]),
                'sort_order' => 3,
                'is_active' => true,
            ]);

            HeroSlide::create([
                'title' => 'Casuals & Essential Luxe',
                'subtitle' => 'Effortless daytime chic sculpted with comfort in mind.',
                'tag' => 'NEW CASUALS',
                'media_type' => 'image',
                'image_path' => 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?auto=format&fit=crop&w=1200&q=80',
                'button_text' => 'Browse Catalog',
                'button_link' => '#catalog',
                'sort_order' => 4,
                'is_active' => true,
            ]);
        }
    }
}
