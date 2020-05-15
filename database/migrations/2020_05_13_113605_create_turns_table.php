<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turns', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('player_id')->unsigned()->index();
            $table->bigInteger('game_id')->unsigned()->index();
            $table->bigInteger('tile_id')->unsigned()->index();
            $table->string('side', 10)->default('right');
            $table->smallInteger('left_pile_ends_in')->unsigned();
            $table->smallInteger('right_pile_ends_in')->unsigned();
            $table->integer('order')->unsigned()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turns');
    }
}
