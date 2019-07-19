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
        Schema::dropIfExists('items');
        Schema::create('items', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('certificate_number');
            $table->integer('discovery_points');
            $table->integer('adventure_points');
            $table->double('multiplier_increment');
            $table->boolean('discovered')->default(false);
            $table->unsignedInteger('discovered_by_id')->nullable();
            $table->timestamps();
        });

        Schema::dropIfExists('players');
        Schema::create('players', function(Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('level')->default(1);
            $table->integer('score')->default(0);
            $table->unsignedInteger('team_id')->nullable();
            $table->timestamps();
        });

        Schema::dropIfExists('teams');
        Schema::create('teams', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('score')->default(0);
            $table->double('score_multiplier')->default(1.0);
            $table->timestamps();
        });

        // Constraints

        Schema::table('items', function(Blueprint $table) {
            $table->foreign('discovered_by_id')->references('id')->on('players');
        });
        Schema::table('players', function(Blueprint $table) {
            $table->foreign('team_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
        Schema::dropIfExists('players');
    }
}
