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
     * gets a list of games
     *
     * pagination is set to 100 for the demo
     *
     * @return void
     */
    public function index()
    {
        return $this->model->with(['owner'])->paginate(100);
    }
}
