<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Events\Inst;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Create admin account
        DB::table('users')->insert([
            'usertype' => 'Admin',
            'username' => 'admin',
            'username_slug' => 'admin',
            'icon' => null,
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        if (env('APP_DEMO')) {
            // Create admin account
            DB::table('users')->insert([
                'usertype' => 'Admin',
                'username' => 'demo',
                'username_slug' => 'demo',
                'icon' => null,
                'email' => 'demo@admin.com',
                'password' => bcrypt('demoadmin'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }

        // factory('App\User', 20)->create();
    }
}
