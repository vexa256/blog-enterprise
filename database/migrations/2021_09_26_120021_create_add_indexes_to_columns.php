<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddIndexesToColumns extends Migration
{

    private function indexIfNotExist($tableName, $indexName)
    {
        Schema::table($tableName, function (Blueprint $table) use ($tableName, $indexName) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $doctrineTable = $sm->listTableIndexes($tableName);

            if (array_key_exists($indexName, $doctrineTable)) {
                $table->index($indexName);
            }
        });
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->indexIfNotExist('categories', 'type');
        $this->indexIfNotExist('categories', 'name_slug');
        $this->indexIfNotExist('categories', 'language');

        $this->indexIfNotExist('posts', 'published_at');
        $this->indexIfNotExist('posts', 'featured_at');
        $this->indexIfNotExist('posts', 'approve');
        $this->indexIfNotExist('posts', 'language');

        $this->indexIfNotExist('reactions', 'post_id');
        $this->indexIfNotExist('reactions', 'user_id');
        $this->indexIfNotExist('reactions', 'reaction_type');

        $this->indexIfNotExist('reactions_icons', 'reaction_type');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
