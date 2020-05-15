<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('owner_id')->unsigned()->index();
            $table->bigInteger('winner_id')->unsigned()->index()->nullable();
            $table->bigInteger('current_turn')->unsigned()->index()->nullable();
            $table->timestamps();
        });
        Schema::create('game_tile', function (Blueprint $table) {
            $table->bigInteger('tile_id')->unsigned()->index();
            $table->bigInteger('game_id')->unsigned()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
        Schema::dropIfExists('game_tile');
    }
}
