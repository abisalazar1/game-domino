<?php

namespace App\Repositories;

use App\Player;

class PlayerRepository extends Repository
{
    /**
     * PlayerRepository Constructor
     *
     * @param Player $player
     */
    public function __construct(Player $player)
    {
        $this->model = $player;
    }


    /**
     * Checks if user has a specific tile
     *
     * @param int $gameId
     * @param int $userId
     * @param int $tileId
     *
     * @return int
     */
    public function checkPlayersHandForTile(int $gameId, int $userId, int $tileId)
    {
        return $this->model->where([
            ['game_id', $gameId],
            ['user_id', $userId]
        ])->whereHas('tiles', function ($query) use ($tileId) {
            $query->where('tiles.id', $tileId);
        })->count();
    }
}
