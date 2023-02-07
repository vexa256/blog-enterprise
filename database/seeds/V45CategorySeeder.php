<?php

namespace Database\Seeders;

use App\Tag;
use App\Category;
use App\Contacts;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class V45CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        collect(Category::all())->each(function ($category) {
            if (in_array($category->type, ['mailcat', 'maillabel', 'mailprivatecat'])) {
                $tag = Tag::firstOrCreate([
                    'name' => $category->name,
                    'slug' =>  $category->name_slug,
                    'type' => $category->type,
                    'color' => $category->description,
                    'icon' => $category->icon
                ]);
                collect(Contacts::where('category_id', $category->id)->get())
                    ->each(function ($contact) use ($tag) {
                        $contact->update(['category_id' => $tag->id]);
                    });
                collect(Contacts::where('label_id', $category->id)->get())
                    ->each(function ($contact) use ($tag) {
                        $contact->update(['label_id' => $tag->id]);
                    });

                $category->delete();
            } elseif (!in_array($category->type, ['news', 'list', 'quiz', 'video', 'poll'])) {
                if (Category::find($category->type)) {
                    $category->parent_id = $category->type;
                    $category->type = null;
                    $category->update();
                }
            }
        });

        Model::reguard();
    }
}
