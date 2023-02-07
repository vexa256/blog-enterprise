<?php

namespace Database\Factories;

use App\Post;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence();

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'body' => $this->faker->paragraph(),
            'thumb' => $this->faker->imageUrl(),
            'type' => $this->faker->randomElement(['news', 'list', 'quiz', 'poll', 'video']),
            'approve' => 'yes',
            'language' => 'en',
            'published_at' => now(),
        ];
    }
}
