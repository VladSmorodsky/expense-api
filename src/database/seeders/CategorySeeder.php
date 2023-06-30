<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    private array $categories = [
        'Food and Drinks',
        'Shopping',
        'Housing',
        'Transportation',
        'Life & Entertainment',
        'Communication',
        'Charity'
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->categories as $category) {
            Category::factory()->create(['name' => $category]);
        }
    }
}
