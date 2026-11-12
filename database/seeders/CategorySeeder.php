<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Lập trình Web & Backend', 'slug' => 'lap-trinh-web-backend'],
            ['name' => 'Khoa học Dữ liệu & AI', 'slug' => 'khoa-hoc-du-lieu-ai'],
            ['name' => 'Luyện thi Thuật toán & OJ', 'slug' => 'luyen-thi-thuat-toan-oj'],
        ];

        foreach ($categories as $item) {
            Category::updateOrCreate(['slug' => $item['slug']], ['name' => $item['name']]);
        }
    }
}
