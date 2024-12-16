<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Технологии']);
        Category::create(['name' => 'Спорт']);
        Category::create(['name' => 'Культура']);
    }
}
