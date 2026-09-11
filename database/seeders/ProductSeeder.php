<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $corporate = Category::where('name', 'Corporate Wears')->first();
        $party = Category::where('name', 'Party Dresses')->first();
        $evening = Category::where('name', 'Evening Dresses')->first();
        $luxury = Category::where('name', 'Luxury Wears')->first();
        $sets = Category::where('name', 'Two Piece Sets')->first();
        $casuals = Category::where('name', 'Casuals')->first();
        $tops = Category::where('name', 'Tops, Shirts & Tees')->first();
        $denim = Category::where('name', 'Denim')->first();
        $tummy = Category::where('name', 'Tummy Control & Bras')->first();
        $pants = Category::where('name', 'Pants & Shorts')->first();
        $shoesBags = Category::where('name', 'Shoes & Bags')->first();
        $accessories = Category::where('name', 'Accessories')->first();

        $products = [
            // Corporate Wears
            [
                'category_id' => $corporate?->id,
                'name' => 'Double-Breasted Structured Trench Dress',
                'description' => 'Sophisticated tailored blazer dress with peak lapels, tortoiseshell buttons, and detachable matching waist belt. Perfect boardroom-to-evening style for curvy silhouettes.',
                'price' => 340.00,
                'sizes' => 'UK 12, UK 14, UK 16, UK 18, UK 20, UK 22',
                'image' => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => Product::STATUS_ACTIVE,
            ],
            [
                'category_id' => $corporate?->id,
                'name' => 'Monochrome Pleated Belted Midi Shift Dress',
                'description' => 'Refined office elegance crafted from wrinkle-resistant crepe with flattering front pleats and gold-accented waist belt.',
                'price' => 290.00,
                'sizes' => 'UK 10, UK 12, UK 14, UK 16, UK 18, UK 20',
                'image' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => Product::STATUS_ACTIVE,
            ],

            // Party Dresses
            [
                'category_id' => $party?->id,
                'name' => 'Sunkissed Ribbed Bodycon Midi Dress',
                'description' => 'Flattering ribbed stretch knit dress designed to hug and accentuate your curves in all the right places. Features a side slit and square neckline.',
                'price' => 220.00,
                'sizes' => 'UK 10, UK 12, UK 14, UK 16, UK 18, UK 20, UK 22',
                'image' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => Product::STATUS_ACTIVE,
            ],
            [
                'category_id' => $party?->id,
                'name' => 'Midnight Black Ruched Halter Jumpsuit',
                'description' => 'Sleek wide-leg halter jumpsuit tailored with a ruched bodice for a snatched waistline and elongating drape.',
                'price' => 280.00,
                'sizes' => 'UK 12, UK 14, UK 16, UK 18, UK 20, UK 22',
                'image' => 'https://images.unsplash.com/photo-1509631179647-0177331693ae?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => Product::STATUS_ACTIVE,
            ],

            // Evening Dresses
            [
                'category_id' => $evening?->id,
                'name' => 'Emerald Satin Wrap Maxi Dress',
                'description' => 'Luxurious rich emerald satin with adjustable waist tie and flowing romantic hemline. Perfect for weddings, dinners, and special occasions.',
                'price' => 320.00,
                'sizes' => 'UK 12, UK 14, UK 16, UK 18, UK 20',
                'image' => 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => Product::STATUS_ACTIVE,
            ],
            [
                'category_id' => $evening?->id,
                'name' => 'Royal Velvet Off-Shoulder Column Gown',
                'description' => 'Dramatically flattering stretch velvet evening gown with structured corset bodice, subtle sweetheart neckline, and a graceful floor-sweeping hem.',
                'price' => 450.00,
                'sizes' => 'UK 12, UK 14, UK 16, UK 18, UK 20, UK 22',
                'image' => 'https://images.unsplash.com/photo-1566174053879-31528523f8ae?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => Product::STATUS_ACTIVE,
            ],

            // Luxury Wears
            [
                'category_id' => $luxury?->id,
                'name' => 'Handcrafted Silk Satin Kimono Duster & Slip',
                'description' => 'A statement luxury piece in lustrous heavyweight silk satin with contrast gold piping and matching bias-cut inner slip.',
                'price' => 520.00,
                'sizes' => 'Free Size (UK 12 - 24)',
                'image' => 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => Product::STATUS_ACTIVE,
            ],
            [
                'category_id' => $luxury?->id,
                'name' => 'Champagne Organza Puff-Sleeve Blouse',
                'description' => 'Dramatic organza sheer sleeves paired with a structured sweetheart bodice. Elevated glam for date nights and cocktail hours.',
                'price' => 180.00,
                'sizes' => 'UK 12, UK 14, UK 16, UK 18, UK 20',
                'image' => 'https://images.unsplash.com/photo-1564257631407-4deb1f99d992?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => Product::STATUS_ACTIVE,
            ],

            // Two-Piece Sets
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

            // Casuals
            [
                'category_id' => $casuals?->id,
                'name' => 'Terracotta Linen Cutout Sundress',
                'description' => 'Breathable premium linen blend dress with subtle side cutouts and a flared A-line silhouette. Chic, breezy, and effortlessly stylish.',
                'price' => 195.00,
                'sizes' => 'UK 10, UK 12, UK 14, UK 16, UK 18',
                'image' => 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => Product::STATUS_ACTIVE,
            ],
            [
                'category_id' => $casuals?->id,
                'name' => 'Tiered Cotton Smock Day Dress (Blush)',
                'description' => 'Floaty breathable pure cotton day dress with puff sleeves and comfortable tiered skirt. Effortless weekend luxury in Accra heat.',
                'price' => 185.00,
                'sizes' => 'UK 10, UK 12, UK 14, UK 16, UK 18, UK 20',
                'image' => 'https://images.unsplash.com/photo-1515372039744-b8f02a3ae446?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => Product::STATUS_ACTIVE,
            ],

            // Tops, Shirts & Tees
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

            // Denim
            [
                'category_id' => $denim?->id,
                'name' => 'High-Waist Sculpting Stretch Denim Jeans',
                'description' => 'Curves & Tees signature curve-fit denim engineered to eliminate waist gap while providing generous hip and thigh ease.',
                'price' => 240.00,
                'sizes' => 'UK 12, UK 14, UK 16, UK 18, UK 20, UK 22',
                'image' => 'https://images.unsplash.com/photo-1541099649105-f69ad21f3246?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => Product::STATUS_ACTIVE,
            ],
            [
                'category_id' => $denim?->id,
                'name' => 'Curve-Enhancing Denim Midi Skirt (Vintage Wash)',
                'description' => 'Classic five-pocket denim midi skirt with front walking slit and high-stretch recovery denim. Hugs the waist with no gapping.',
                'price' => 210.00,
                'sizes' => 'UK 12, UK 14, UK 16, UK 18, UK 20',
                'image' => 'https://images.unsplash.com/photo-1576995853123-5a10305d93c0?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => Product::STATUS_ACTIVE,
            ],

            // Tummy Control & Bras
            [
                'category_id' => $tummy?->id,
                'name' => 'Curves Seamless Hourglass Shaper Shorts',
                'description' => 'Lightweight high-waist shaping shorts with stay-put silicone grip band. Smooths and sculpts comfortably under all fitted garments.',
                'price' => 110.00,
                'sizes' => 'M/L, XL/2XL, 3XL/4XL',
                'image' => 'https://images.unsplash.com/photo-1582533561751-ef6f6ab93a2e?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => Product::STATUS_ACTIVE,
            ],
            [
                'category_id' => $tummy?->id,
                'name' => 'All-Day Contour High-Waist Shaper Brief',
                'description' => 'Targeted tummy compression with flexible boning and breathable mesh panelling. Delivers smooth posture and zero waist-roll all day.',
                'price' => 95.00,
                'sizes' => 'L, XL, 2XL, 3XL, 4XL',
                'image' => 'https://images.unsplash.com/photo-1582533561751-ef6f6ab93a2e?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => Product::STATUS_ACTIVE,
            ],

            // Pants & Shorts
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
            [
                'category_id' => $pants?->id,
                'name' => 'High-Rise Linen Belted City Shorts',
                'description' => 'Tailored pleated linen shorts designed with a flattering A-line leg cut and removable fabric buckle belt.',
                'price' => 160.00,
                'sizes' => 'UK 12, UK 14, UK 16, UK 18, UK 20',
                'image' => 'https://images.unsplash.com/photo-1591195853828-11db59a44f6b?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => Product::STATUS_ACTIVE,
            ],

            // Shoes & Bags
            [
                'category_id' => $shoesBags?->id,
                'name' => 'Woven Leather Structured Handbag (Cognac)',
                'description' => 'Hand-woven vegan leather tote with gold hardware, detachable cross-body strap, and spacious luxury interior lining.',
                'price' => 280.00,
                'sizes' => 'One Size',
                'image' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?auto=format&fit=crop&w=800&q=80',
                'is_featured' => true,
                'status' => Product::STATUS_ACTIVE,
            ],
            [
                'category_id' => $shoesBags?->id,
                'name' => 'Metallic Gold Strappy Block Heel Sandal',
                'description' => 'Chic 2.5-inch block heel designed with cushioned arch support for all-night celebration comfort. Features dainty square toe and ankle strap.',
                'price' => 260.00,
                'sizes' => 'EU 38, EU 39, EU 40, EU 41, EU 42, EU 43',
                'image' => 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => Product::STATUS_ACTIVE,
            ],

            // Accessories
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
                'name' => 'Hammered Gold Draped Statement Choker',
                'description' => 'Lightweight 18k gold-plated statement collar necklace that frames collarbones exquisitely over dresses and tops.',
                'price' => 75.00,
                'sizes' => 'Adjustable',
                'image' => 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?auto=format&fit=crop&w=800&q=80',
                'is_featured' => false,
                'status' => Product::STATUS_ACTIVE,
            ],
        ];

        foreach ($products as $item) {
            Product::firstOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
