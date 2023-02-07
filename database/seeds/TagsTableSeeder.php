<?php

namespace Database\Seeders;

use App\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::firstOrCreate([
            'name' => 'Inbox',
            'slug' => 'inbox',
            'icon' => 'inbox',
            'type' => 'mailcat',
        ]);
        Tag::firstOrCreate([
            'name' => 'Sent',
            'slug' => 'sent',
            'icon' => 'envelope-o',
            'type' => 'mailcat',
        ]);
        Tag::firstOrCreate([
            'name' => 'Drafts',
            'slug' => 'drafts',
            'icon' => 'file-text-o',
            'type' => 'mailcat',
        ]);
        Tag::firstOrCreate([
            'name' => 'Junk',
            'slug' => 'junk',
            'icon' => 'filter',
            'type' => 'mailcat',
        ]);
        Tag::firstOrCreate([
            'name' => 'Trash',
            'slug' => 'trash',
            'icon' => 'trash-o',
            'type' => 'mailcat',
        ]);
        Tag::firstOrCreate([
            'name' => 'Advertisement',
            'slug' => 'advertisement',
            'icon' => '',
            'type' => 'maillabel',
        ]);
        Tag::firstOrCreate([
            'name' => 'Other',
            'slug' => 'other',
            'icon' => '',
            'type' => 'maillabel',
        ]);
    }
}
