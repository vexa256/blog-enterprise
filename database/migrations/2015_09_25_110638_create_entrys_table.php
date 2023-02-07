<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntrysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('entrys')) {
            Schema::create('entrys', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('post_id')->index();
                $table->integer('user_id')->index()->nullable();
                $table->integer('order')->nullable();
                $table->string('type')->nullable();
                $table->string('title', 255)->nullable();
                $table->text('body')->nullable();
                $table->string('image')->nullable();
                $table->string('video', 1000)->nullable();
                $table->string('source', 1000)->nullable();
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
        // Schema::drop('entrys');
    }
}
