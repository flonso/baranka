<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInitialTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('certificate_number');
            $table->integer('discovery_points');
            $table->integer('adventure_points');
            $table->double('multiplier_increment');
            $table->boolean('discovered');
            $table->integer('discovered_by_id');
            $table->timestamps();

            // $table->foreign('discovered_by_id')->references('id')->on('players');
        });
        /*
        Schema::create('players', function(Blueprint $table) {

        });

        Schema::create('teams', function(Blueprint $table) {

        });

        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('boat_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
