<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemPlayerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign('items_discovered_by_id_foreign');
            $table->dropColumn('discovered_by_id');
        });

        Schema::create('item_player', function(Blueprint $table) {
            $table->unsignedInteger('item_id');
            $table->unsignedInteger('player_id');

            $table->foreign('player_id')->references('id')->on('players');
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->unsignedInteger('discovered_by_id')->nullable();
        });

        Schema::table('items', function(Blueprint $table) {
            $table->foreign('discovered_by_id')->references('id')->on('players');
        });

        Schema::dropIfExists('item_player');
    }
}
