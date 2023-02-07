<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLanguageColumnToReactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('reactions_icons', 'language')) {
            Schema::table('reactions_icons', function (Blueprint $table) {
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
        if (Schema::hasColumn('reactions_icons', 'language')) {
            Schema::table('reactions_icons', function (Blueprint $table) {
                $table->dropColumn('language');
            });
        }
    }
}
