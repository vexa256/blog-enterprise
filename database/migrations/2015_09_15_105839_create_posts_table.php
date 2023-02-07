<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('posts')) {
            Schema::create('posts', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->index();
                $table->integer('category_id')->index()->nullable();
                $table->string('categories')->index()->nullable();
                $table->string('type', 25)->index();
                $table->string('ordertype', 25)->nullable();
                $table->string('slug');
                $table->string('title')->index();
                $table->text('body')->nullable();
                $table->string('thumb')->nullable();
                $table->string('approve', 5)->nullable();
                $table->string('show_in_homepage', 5)->nullable();
                $table->text('shared')->nullable();
                $table->text('tags')->nullable();
                $table->integer('pagination')->nullable();
                $table->timestamp('featured_at')->nullable();
                $table->timestamp('published_at')->nullable();
                $table->timestamps();
                $table->softDeletes();
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
        Schema::drop('posts');
    }
}
