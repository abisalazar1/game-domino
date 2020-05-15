<?php

use App\Tile;
use App\Piece;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiles', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('right_side')->unsigned();
            $table->smallInteger('left_side')->unsigned();
            $table->timestamps();
        });

        // Creates the pieces / Tiles
        $sideTwo = 0;

        for ($sideOne = 0; $sideTwo <= 6;) {
            factory(Tile::class)->create([
                'right_side' => $sideOne,
                'left_side' => $sideTwo
            ]);

            if ($sideOne === $sideTwo) {
                $sideTwo++;
                $sideOne = 0;
            } else {
                $sideOne++;
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tiles');
    }
}
