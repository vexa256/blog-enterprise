<?php

namespace Database\Factories;

use App\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->words(1, true);

        return [
            'name' => $title,
            'name_slug' => Str::slug($title),
            'posturl_slug' => Str::slug($title),
            'description' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['news', 'list', 'quiz', 'poll', 'video']),
            'parent_id' => Category::whereNull('parent_id')->inRandomOrder()->first(),
            'disabled' => '0',
            'language' => 'en',
        ];
    }
}
