<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguageColumnToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('posts', 'language')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->string('language', 5)->default(config('app.locale'))->nullable();
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
        if (Schema::hasColumn('posts', 'language')) {
            Schema::table('posts', function (Blueprint $table) {
                $table->dropColumn('language');
            });
        }
    }
}
