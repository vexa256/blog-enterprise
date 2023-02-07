<?php

namespace Database\Seeders;

use App\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class V49PostStatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('popularity_stats')->latest()->chunk(100, function ($stats) {
            collect($stats)->map(function ($stat) {
                $post = Post::find($stat->trackable_id);
                if ($post) {
                    $post->update([
                        'one_day_stats' => $stat->one_day_stats,
                        'seven_days_stats' => $stat->seven_days_stats,
                        'thirty_days_stats' => $stat->thirty_days_stats,
                        'all_time_stats' => $stat->all_time_stats,
                        'raw_stats' => $stat->raw_stats,
                    ]);
                }

                DB::table('popularity_stats')->where('id', $stat->id)->delete();
            });
        });
    }
}
