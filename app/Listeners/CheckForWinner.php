<?php

namespace App\Listeners;

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

        if (!$player->tiles()->count()) {
            $event->turn->game->setWinnerId($player->user_id);
        }
    }
}
