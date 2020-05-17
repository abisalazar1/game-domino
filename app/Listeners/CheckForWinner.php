<?php

namespace App\Listeners;

use App\Events\CheckTiles;
use App\Events\SetUpNextTurn;

class CheckForWinner
{
    /**
     * Handle the event
     *
     * @param SetUpNextTurn $event
     *
     * @return void
     */
    public function handle(SetUpNextTurn $event)
    {
        $player = $event->turn->player;

        $game = $event->turn->game;

        if (!$player->tiles()->count()) {
            $event->turn->game->setWinnerId($player->user_id);
        }

        CheckTiles::dispatch($game);
    }
}
