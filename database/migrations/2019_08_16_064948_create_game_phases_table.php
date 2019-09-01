<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateGamePhasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_phases', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('number');
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime')->nullable();
            $table->timestampsTz();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->unsignedInteger('game_phase_id');
            $table->foreign('game_phase_id')->references('id')->on('game_phases');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign('events_game_phase_id_foreign');
            $table->dropColumn('game_phase_id');
        });
        Schema::dropIfExists('game_phases');
    }
}
