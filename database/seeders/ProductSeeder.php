<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $dresses = Category::where('name', 'Dresses & Jumpsuits')->first();
        $tops = Category::where('name', 'Tops & Graphic Tees')->first();
        $sets = Category::where('name', 'Two-Piece Sets & Co-Ords')->first();
        $pants = Category::where('name', 'Pants, Skirts & Denim')->first();
        $accessories = Category::where('name', 'Accessories & Essentials')->first();

        $products = [
            // Dresses & Jumpsuits
            [
                'category_id' => $dresses?->id,
                'name' => 'Sunkissed Ribbed Bodycon Midi Dress',
                'description' => 'Flattering ribbed stretch knit dress designed to hug and accentuate your curves in all the right places. Features a side slit and square neckline.',
                'price' => 220.00,
                'sizes' => 'UK 10, UK 12, UK 14, UK 16, UK 18, UK 20, UK 22',
                'image' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => Product::STATUS_ACTIVE,
            ],
            [
                'category_id' => $dresses?->id,
                'name' => 'Emerald Satin Wrap Maxi Dress',
                'description' => 'Luxurious rich emerald satin with adjustable waist tie and flowing romantic hemline. Perfect for weddings, dinners, and special occasions.',
                'price' => 320.00,
                'sizes' => 'UK 12, UK 14, UK 16, UK 18, UK 20',
                'image' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => Product::STATUS_ACTIVE,
            ],
            [
                'category_id' => $dresses?->id,
                'name' => 'Terracotta Linen Cutout Sundress',
                'description' => 'Breathable premium linen blend dress with subtle side cutouts and a flared A-line silhouette. Chic, breezy, and effortlessly stylish.',
                'price' => 195.00,
                'sizes' => 'UK 10, UK 12, UK 14, UK 16, UK 18',
                'image' => 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => Product::STATUS_ACTIVE,
            ],
            [
                'category_id' => $dresses?->id,
                'name' => 'Midnight Black Ruched Halter Jumpsuit',
                'description' => 'Sleek wide-leg halter jumpsuit tailored with a ruched bodice for a snatched waistline and elongating drape.',
                'price' => 280.00,
                'sizes' => 'UK 12, UK 14, UK 16, UK 18, UK 20, UK 22',
                'image' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => Product::STATUS_ACTIVE,
            ],

            // Tops & Graphic Tees
            [
                'category_id' => $tops?->id,
                'name' => '"Curvy & Confident" Oversized Statement Tee',
                'description' => 'Heavyweight 100% premium cotton tee featuring a vintage screen-printed statement. Relaxed drop-shoulder fit that pairs with bike shorts or mom jeans.',
                'price' => 120.00,
                'sizes' => 'M, L, XL, 2XL, 3XL',
                'image' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => Product::STATUS_ACTIVE,
            ],
            [
                'category_id' => $tops?->id,
                'name' => 'Cocoa Butter Double-Layer Crop Top',
                'description' => 'Ultra-soft sculpting fabric that provides seamless support without underwires. High-elasticity breathable blend in rich cocoa shade.',
                'price' => 95.00,
                'sizes' => 'UK 10, UK 12, UK 14, UK 16, UK 18',
                'image' => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => Product::STATUS_ACTIVE,
            ],
            [
                'category_id' => $tops?->id,
                'name' => 'Champagne Organza Puff-Sleeve Blouse',
                'description' => 'Dramatic organza sheer sleeves paired with a structured sweetheart bodice. Elevated glam for date nights and cocktail hours.',
                'price' => 180.00,
                'sizes' => 'UK 12, UK 14, UK 16, UK 18, UK 20',
                'image' => 'https://images.unsplash.com/photo-1564257631407-4deb1f99d992?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => Product::STATUS_ACTIVE,
            ],

            // Two-Piece Sets & Co-Ords
            [
                'category_id' => $sets?->id,
                'name' => 'Mustard Glow Plisse Pleated Two-Piece Set',
                'description' => 'High-stretch micro-pleated button-down shirt paired with fluid wide-leg palazzo pants. Luxurious travel and lounge aesthetic.',
                'price' => 310.00,
                'sizes' => 'UK 12, UK 14, UK 16, UK 18, UK 20, UK 22',
                'image' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => Product::STATUS_ACTIVE,
            ],
            [
                'category_id' => $sets?->id,
                'name' => 'Safari Knit Sleeveless Top & Skirt Co-Ord',
                'description' => 'Contoured ribbed knit two-piece matching set. High-waisted midi skirt with elasticated waist and matching cropped racerback tank.',
                'price' => 260.00,
                'sizes' => 'UK 10, UK 12, UK 14, UK 16, UK 18',
                'image' => 'https://images.unsplash.com/photo-1485968579580-b6d095142e6e?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => Product::STATUS_ACTIVE,
            ],

            // Pants, Skirts & Denim
            [
                'category_id' => $pants?->id,
                'name' => 'High-Waist Sculpting Stretch Denim Jeans',
                'description' => 'Curves & Tees signature curve-fit denim engineered to eliminate waist gap while providing generous hip and thigh ease.',
                'price' => 240.00,
                'sizes' => 'UK 12, UK 14, UK 16, UK 18, UK 20, UK 22',
                'image' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => Product::STATUS_ACTIVE,
            ],
            [
                'category_id' => $pants?->id,
                'name' => 'Tailored Pleated Wide-Leg Trousers (Olive)',
                'description' => 'Sophisticated tailored trousers with deep front pleats, slant pockets, and a clean belt-looped waistband.',
                'price' => 210.00,
                'sizes' => 'UK 10, UK 12, UK 14, UK 16, UK 18, UK 20',
                'image' => 'https://images.unsplash.com/photo-1509551388413-e18d0ac5d495?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => Product::STATUS_ACTIVE,
            ],

            // Accessories & Essentials
            [
                'category_id' => $accessories?->id,
                'name' => 'Gold Hammered Statement Buckle Belt',
                'description' => 'Supple faux-leather cinch belt with an organic hammered gold buckle. Designed to define waistlines over dresses, blazers, and oversized tees.',
                'price' => 85.00,
                'sizes' => 'One Size (Adjustable)',
                'image' => 'https://images.unsplash.com/photo-1624222247344-550fb60583dc?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => Product::STATUS_ACTIVE,
            ],
            [
                'category_id' => $accessories?->id,
                'name' => 'Curves Seamless Hourglass Shaper Shorts',
                'description' => 'Lightweight high-waist shaping shorts with stay-put silicone grip band. Smooths and sculpts comfortably under all fitted garments.',
                'price' => 110.00,
                'sizes' => 'M/L, XL/2XL, 3XL/4XL',
                'image' => 'https://images.unsplash.com/photo-1582533561751-ef6f6ab93a2e?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => Product::STATUS_ACTIVE,
            ],
        ];

        foreach ($products as $data) {
            Product::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}
