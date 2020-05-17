<?php

namespace App\Services\Game;

use App\Game;
use App\User;
use App\Events\CheckTiles;
use App\Repositories\GameRepository;

class SkipTurnService
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
     * Skips users turn
     *
     * @return
     */
    public function skip()
    {
        $players =  $this->game->players;

        $player = $this->getPlayer();

        $nextPostion = count($players) === $player->position ? 1 : $player->position + 1;

        $nextUserToPlay = $players->first(function ($player) use ($nextPostion) {
            return $player->position === $nextPostion;
        });

        $this->game->setCurrentTurn($nextUserToPlay->user_id);

        CheckTiles::dispatch($this->game);
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
