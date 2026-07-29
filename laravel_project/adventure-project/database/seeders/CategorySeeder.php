<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Hiking'],
            ['name' => 'Water Sports'],
            ['name' => 'Camping'],
            ['name' => 'Wildlife'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate($category);
        }
    }
}
