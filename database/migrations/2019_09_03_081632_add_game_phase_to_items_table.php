<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddGamePhaseToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE players MODIFY score DOUBLE");
        DB::statement("ALTER TABLE teams MODIFY score DOUBLE");

        Schema::table('items', function (Blueprint $table) {
            $table->unsignedInteger('discoverable_from_phase');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        DB::statement("ALTER TABLE players MODIFY score INTEGER");
        DB::statement("ALTER TABLE teams MODIFY score INTEGER");

        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('discoverable_from_phase');
        });
    }
}
