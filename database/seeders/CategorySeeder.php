<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Corporate Wears',
            'Party Dresses',
            'Evening Dresses',
            'Luxury Wears',
            'Two Piece Sets',
            'Casuals',
            'Tops, Shirts & Tees',
            'Denim',
            'Tummy Control & Bras',
            'Pants & Shorts',
            'Shoes & Bags',
            'Accessories',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(
                ['name' => $name],
                ['status' => Category::STATUS_ACTIVE]
            );
        }
    }
}
