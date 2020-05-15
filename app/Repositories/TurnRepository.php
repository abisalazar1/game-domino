<?php

namespace App\Repositories;

use App\Turn;

class TurnRepository extends Repository
{
    /**
     * TurnRepository Constructor
     *
     * @param Turn $turn
     */
    public function __construct(Turn $turn)
    {
        $this->model = $turn;
    }

    /**
     * Gets the latest turns
     *
     * @param int $gameId
     * @param int $limit
     * @param string $side
     *
     * @return void
     */
    public function getLastestTurnsByGameId(int $gameId, $limit = 4, string $side = null)
    {
        $query = $this->model->where('game_id', $gameId);

        if ($side) {
            $query->where('side', $side);
        }

        return $query->latest()->limit($limit)->get();
    }

    /**
     * checks if the game has at least one turn
     *
     * @param int $gameId
     *
     * @return bool
     */
    public function hasBeenPlayedYet(int $gameId)
    {
        return !!$this->model->where('game_id', $gameId)->count();
    }

    /**
     * gets the last turn
     *
     * @param int $gameId
     *
     * @return Turn
     */
    public function getLastTurnByGameId(int $gameId)
    {
        return $this->model->where('game_id', $gameId)->latest()->first();
    }
}
