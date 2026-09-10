<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Dresses & Jumpsuits',
            'Tops & Graphic Tees',
            'Two-Piece Sets & Co-Ords',
            'Pants, Skirts & Denim',
            'Accessories & Essentials',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(
                ['name' => $name],
                ['status' => Category::STATUS_ACTIVE]
            );
        }
    }
}
