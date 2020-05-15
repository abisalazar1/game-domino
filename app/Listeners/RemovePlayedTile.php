<?php

namespace App\Listeners;

use App\Events\SetUpNextTurn;

class RemovePlayedTile
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
        $event->turn->player->tiles()->detach($event->turn->tile_id);
    }
}
