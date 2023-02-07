<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('feeds')) {
            Schema::create('feeds', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('url', 500);
                $table->string('interval');
                $table->string('content_fetcher')->default('custom');
                $table->string('post_categories');
                $table->integer('post_user_id');
                $table->integer('post_fetch_count')->default(10);
                $table->timestamp('checked_at')->nullable();
                $table->string('language', 5)->default(config('app.locale'))->nullable();
                $table->boolean('active')->default(1);
                $table->timestamps();
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
        Schema::dropIfExists('feeds');
    }
}
