<?php

namespace Database\Seeders;

use App\Post;
use App\User;
use App\Category;
use Illuminate\Database\Seeder;

class FakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(1000)->create();
        Category::factory()->count(100)->create();

        Post::factory()->count(1000)
            ->for(User::inRandomOrder()->first())
            ->create()
            ->each(function ($post) {
                $randomFields = Category::all()->random(rand(0, 4))->pluck('id');
                $post->categories()->attach($randomFields);
            });
    }
}
