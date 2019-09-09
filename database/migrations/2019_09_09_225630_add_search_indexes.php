<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSearchIndexes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function(Blueprint $table) {
            $table->index('name');
        });

        Schema::table('players', function(Blueprint $table) {
            $table->index(['first_name', 'last_name']);
            $table->index('first_name');
            $table->index('last_name');
            $table->index('code');
            $table->index('score');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function(Blueprint $table) {
            $table->dropIndex('items_name_index');
        });

        Schema::table('players', function(Blueprint $table) {
            $table->dropIndex('players_first_name_last_name_index');
            $table->dropIndex('players_first_name_index');
            $table->dropIndex('players_last_name_index');
            $table->dropIndex('players_code_index');
            $table->dropIndex('players_score_index');
        });
    }
}
