<?php

namespace App\Listeners;

use App\Events\SetUpNextTurn;

class SetNextTurn
{
    /**
     * Handle event
     *
     * @param SetUpNextTurn $event
     *
     * @return void
     */
    public function handle(SetUpNextTurn $event)
    {
        $game = $event->turn->game;
        
        $player = $event->turn->player;
        
        $players =  $game->players;

        $nextPostion = count($players) === $player->position ? 1 : $player->position + 1;

        $nextUserToPlay = $players->first(function ($player) use ($nextPostion) {
            return $player->position === $nextPostion;
        });

        $game->setCurrentTurn($nextUserToPlay->user_id);
    }
}
