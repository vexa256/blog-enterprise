<?php

namespace Database\Seeders;

use App\Tag;
use App\Post;
use App\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class V45PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        collect(Post::all())->each(function ($post) {
            $post_categories = [];
            if ($post->categories) {
                foreach (json_decode($post->categories) as $category) {
                    if (empty($category)) continue;

                    $categories = array_filter(explode(',', substr($category, 0, -1)));

                    $post_categories[] = end($categories);
                }
                $post->categories()->sync(Category::find($post_categories));
            }


            if ($post->tags) {
                $tagIds = collect(explode(',', $post->tags))->map(function ($tagName) use ($post) {
                    return Tag::firstOrCreate([
                        'name' => $tagName,
                        'slug' => Str::slug($tagName, '-', $post->language),
                        'type' => 'post_tag'
                    ]);
                })->pluck('id');

                $post->tags()->sync($tagIds);
            }

            // $post->category_id = null;
            // $post->categories = null;
            $post->tags = null;

            $post->save();
        });

        Model::reguard();
    }
}
