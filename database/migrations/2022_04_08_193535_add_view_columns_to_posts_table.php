<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViewColumnsToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('posts', 'one_day_stats')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->integer('one_day_stats')->default(0);
                $table->integer('seven_days_stats')->default(0);
                $table->integer('thirty_days_stats')->default(0);
                $table->integer('all_time_stats')->default(0);
                $table->string('raw_stats', 1000)->default('');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
