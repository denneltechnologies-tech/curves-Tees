<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $riceMeals = Category::where('name', 'Rice Meals')->value('id');
        $combos = Category::where('name', 'Streetman Combos & Fries')->value('id');
        $drinks = Category::where('name', 'Drinks & Extras')->value('id');

        $products = [
            // RICE MEALS
            [
                'category_id' => $riceMeals,
                'name' => 'Fried Rice (1 Chicken + 2 Sausages)',
                'description' => 'Delicious seasoned fried rice served with 1 crispy chicken piece and 2 grilled sausages.',
                'price' => 40.00,
            ],
            [
                'category_id' => $riceMeals,
                'name' => 'Jollof Rice (1 Chicken + 2 Sausages)',
                'description' => 'Authentic Ghanaian smoky jollof rice served with 1 crispy chicken piece and 2 grilled sausages.',
                'price' => 45.00,
            ],
            [
                'category_id' => $riceMeals,
                'name' => 'Fried Rice or Jollof Rice (1 Chicken)',
                'description' => 'Your choice of fragrant fried rice or rich jollof rice paired with 1 crispy chicken piece.',
                'price' => 30.00,
            ],
            [
                'category_id' => $riceMeals,
                'name' => 'Egg Fried Rice (1 Chicken + 2 Sausages)',
                'description' => 'Special egg-tossed fried rice with veggies, served with 1 crispy chicken piece and 2 grilled sausages.',
                'price' => 50.00,
            ],
            [
                'category_id' => $riceMeals,
                'name' => 'Egg Jollof Rice (1 Chicken + 2 Sausages)',
                'description' => 'Flavor-packed jollof rice topped with egg, served with 1 crispy chicken piece and 2 grilled sausages.',
                'price' => 55.00,
            ],
            [
                'category_id' => $riceMeals,
                'name' => 'Assorted Fried Rice (1 Chicken + Plantain)',
                'description' => 'Rich assorted fried rice loaded with savory meat bites, served with 1 chicken piece and fried sweet plantain.',
                'price' => 55.00,
            ],
            [
                'category_id' => $riceMeals,
                'name' => 'Assorted Jollof Rice (1 Chicken + Plantain)',
                'description' => 'Signature assorted smoky jollof rice loaded with meats, served with 1 chicken piece and fried sweet plantain.',
                'price' => 60.00,
            ],

            // COMBOS & FRIES
            [
                'category_id' => $combos,
                'name' => 'Streetman Style - Milk & Fries Combo',
                'description' => 'The Ultimate STREETMAN Combo! Golden crispy fries + 1 chicken + 2 sausages + a creamy whipped milkshake.',
                'price' => 65.00,
            ],
            [
                'category_id' => $combos,
                'name' => 'Fries (1 Chicken + 2 Sausages)',
                'description' => 'Hot crispy golden french fries served with 1 tender chicken piece and 2 grilled sausages.',
                'price' => 35.00,
            ],

            // DRINKS & EXTRAS
            [
                'category_id' => $drinks,
                'name' => 'Milkshake',
                'description' => 'Rich, creamy whipped milkshake (Vanilla, Chocolate, Strawberry or Oreo).',
                'price' => 40.00,
            ],
            [
                'category_id' => $drinks,
                'name' => 'Boba',
                'description' => 'Refreshing bubble milk tea with chewy brown sugar tapioca boba pearls.',
                'price' => 50.00,
            ],
            [
                'category_id' => $drinks,
                'name' => 'Soft Drink',
                'description' => 'Chilled refreshing canned soft drink (Coca-Cola, Fanta, Sprite).',
                'price' => 8.00,
            ],
            [
                'category_id' => $drinks,
                'name' => 'Bottled Water',
                'description' => 'Pure cold refreshing bottled water.',
                'price' => 5.00,
            ],
            [
                'category_id' => $drinks,
                'name' => 'Spring Rolls (3 Pcs)',
                'description' => '3 pieces of crunchy golden pastry rolls packed with seasoned vegetables and filling.',
                'price' => 10.00,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['name' => $product['name']],
                [
                    'category_id' => $product['category_id'],
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'status' => Product::STATUS_ACTIVE,
                ]
            );
        }
    }
}
