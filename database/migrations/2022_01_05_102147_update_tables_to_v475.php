<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTablesToV475 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        return;

        // do not run this on the fresh install
        if (!file_exists(storage_path('installed'))) {
            return;
        }

        // refactor for older versions
        try {
            Schema::table('categories', function (Blueprint $table) {
                $table->dropForeign('categories_parent_id_foreign');
            });
            Schema::table('post_categories', function (Blueprint $table) {
                $table->dropForeign('post_categories_category_id_foreign');
                $table->dropForeign('post_categories_post_id_foreign');
            });
        } catch (\Exception $e) {
            //
        }

        Schema::table('posts', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('user_id')->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->id()->change();
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->id()->change();
            $table->unsignedBigInteger('parent_id')->nullable()->change();

            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
        });

        Schema::table('post_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->change();
            $table->unsignedBigInteger('post_id')->change();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });


        Schema::table('taggables', function (Blueprint $table) {
            $table->unsignedBigInteger('tag_id')->change();
            $table->unsignedBigInteger('taggable_id')->change();
            $table->unsignedBigInteger('user_id')->nullable()->change();
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->unsignedBigInteger('thread_id')->change();
            $table->unsignedBigInteger('user_id')->change();
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->unsignedBigInteger('thread_id')->change();
            $table->unsignedBigInteger('user_id')->change();
        });

        Schema::table('message_participants', function (Blueprint $table) {
            $table->unsignedBigInteger('thread_id')->change();
            $table->unsignedBigInteger('user_id')->change();
        });

        Schema::table('reactions', function (Blueprint $table) {
            $table->unsignedBigInteger('post_id')->change();
        });
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
