<?php

namespace App\Repositories;

use App\Game;

class GameRepository extends Repository
{
    /**
     * GameRepository Constructor
     *
     * @param Game $game
     */
    public function __construct(Game $game)
    {
        $this->model = $game;
    }

    /**
     * gets the list for specific user
     *
     * @param int $userId
     *
     * @return void
     */
    public function getListForUser(int $userId)
    {
        return $this->model->with(['owner'])->whereHas('players', function ($query) use ($userId) {
            $query->where('players.user_id', $userId);
        })->paginate(100);
    }
}
