<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::create([
            'user_id' => 1,
            'category_id' => 1,
            'content' => '懺悔1'
        ]);

        Post::create([
          'user_id' => 2,
          'category_id' => 2,
          'content' => '懺悔2'
        ]);

        Post::create([
          'user_id' => 3,
          'category_id' => 3,
          'content' => '懺悔3'
        ]);
    }
}
