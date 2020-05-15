<?php

namespace App\Services\Game;

use App\Game;
use App\User;
use App\Repositories\GameRepository;

class DrawTileService
{
    /**
     * user
     *
     * @var User
     */
    protected $user;

    /**
     * Game
     *
     * @var Game
     */
    protected $game;

    /**
     * GameRepository
     *
     * @var GameRepository
     */
    protected $gameRepository;

    /**
     * Constructor
     *
     * @param GameRepository $gameRepository
     */
    public function __construct(
        GameRepository $gameRepository
    ) {
        $this->gameRepository = $gameRepository;
    }

    /**
     * Sets the game
     *
     * @param int $gameId
     *
     * @return self
     */
    public function setGameById(int $gameId)
    {
        $this->game = $this->gameRepository->find($gameId);

        return $this;
    }

    /**
     * Sets the game
     *
     * @param int $gameId
     *
     * @return self
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Creates the new taken record turn
     *
     * @param array $attributes
     *
     * @return App\Turn
     */
    public function draw()
    {
        $this->game->loadCount('pool');

        if (!$this->game->pool_count) {
            return;
        }

        $tile = $this->game->pool->random();

        $this->game->pool()->detach([$tile->id]);

        $this->getPlayer()->tiles()->attach([$tile->id]);
    }

    /**
     * Gets the player
     *
     * @return App\Player
     */
    private function getPlayer()
    {
        return $this->game->players()->where('user_id', $this->user->id)->first();
    }
}
