<?php

namespace Database\Seeders;

use App\Models\Adventure;
use App\Models\Category;
use Illuminate\Database\Seeder;

class AdventureSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        $adventures = [
            'Mountain Hiking' => $categories->where('name', 'Hiking')->first()?->id,
            'River Kayaking' => $categories->where('name', 'Water Sports')->first()?->id,
            'Forest Camping' => $categories->where('name', 'Camping')->first()?->id,
            'Waterfall Expedition' => $categories->where('name', 'Wildlife')->first()?->id,
        ];

        foreach ($adventures as $title => $categoryId) {
            if ($categoryId) {
                Adventure::create([
                    'title' => $title,
                    'description' => 'Description for ' . $title,
                    'location' => 'Malaysia',
                    'price' => rand(180, 500),
                    'difficulty' => 'Medium',
                    'duration' => '2 Days',
                    'max_people' => 12,
                    'category_id' => $categoryId,
                ]);
            }
        }
    }
}
    }
}
