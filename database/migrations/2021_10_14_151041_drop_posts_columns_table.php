<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropPostsColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('posts', 'category_id')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('category_id');
            });
        }
        if (Schema::hasColumn('posts', 'categories')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('categories');
            });
        }
        if (Schema::hasColumn('posts', 'tags')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('tags');
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
