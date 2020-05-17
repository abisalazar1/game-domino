<?php

namespace App\Events;

use App\Game;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class CheckTiles
{
    use Dispatchable, SerializesModels;

    /**
     * Game
     *
     * @var Game
     */
    public $game;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Game $game)
    {
        $this->game = $game;
    }
}
