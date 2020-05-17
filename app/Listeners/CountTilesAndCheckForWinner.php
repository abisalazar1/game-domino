<?php

namespace App\Listeners;

use App\Events\CheckTiles;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CountTilesAndCheckForWinner
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(CheckTiles $event)
    {
        $game = $event->game;

        $game->loadCount('pool');

        // check for winner if there is nothing left in pool and any of the players can play a card/tile
        if ($game->pool_count) {
            return true;
        }
    
        $game->load('players.tiles');
    
        $pileEndings = [$game->lastTurn->left_pile_ends_in, $game->lastTurn->right_pile_ends_in];
    
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
    
            $game->setWinnerId($winner->user_id);
        }
    }
}
