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

        $game = $event->turn->game;

        $game->loadCount('pool');
        
        if (!$player->tiles()->count()) {
            $event->turn->game->setWinnerId($player->user_id);
        }
        
        // check for winner if there is nothing left in pool and any of the players can play a card/tile
        if ($game->pool_count) {
            return true;
        }

        $game->load('players.tiles');

        $pileEndings = [$event->turn->left_pile_ends_in, $event->turn->right_pile_ends_in];

        // Check all players tiles and check if they can be played
        $canBeUse = $game->players->pluck('tiles')->flatten(1)->first(function ($tile) use ($pileEndings) {
            return in_array($tile->left_side, $pileEndings) || in_array($tile->right_side, $pileEndings);
        });

        /**
         * If there is not tile that can be placed we need to find a winner
         */
        if (!$canBeUse) {
            $winner = $game->players->sortBy(function ($player) {
                return $player->tileSum();
            })->first();

            $event->turn->game->setWinnerId($winner->user_id);
        }
    }
}
