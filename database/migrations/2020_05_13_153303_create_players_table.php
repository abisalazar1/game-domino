<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->index();
            $table->bigInteger('game_id')->unsigned()->index();
            $table->smallInteger('position')->unsigned()->default(1);
            $table->timestamps();
        });

        Schema::create('player_tile', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('player_id')->unsigned()->index();
            $table->bigInteger('tile_id')->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
        Schema::dropIfExists('player_tile');
    }
}
