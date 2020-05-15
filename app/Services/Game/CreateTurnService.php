<?php

namespace App\Services\Game;

use App\Events\SetUpNextTurn;
use App\Game;
use App\User;
use App\Repositories\GameRepository;
use App\Repositories\TileRepository;

class CreateTurnService
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
     * TileRepository
     *
     * @var TileRepository
     */
    protected $tileRepository;

    /**
     * Tile
     *
     * @var Tile
     */
    protected $tile;

    /**
     * Last Turn
     *
     * @var Turn
     */
    protected $previousTurn;

    /**
     * Constructor
     *
     * @param GameRepository $gameRepository
     * @param TileRepository $tileRepository
     */
    public function __construct(
        GameRepository $gameRepository,
        TileRepository $tileRepository
    ) {
        $this->gameRepository = $gameRepository;
        $this->tileRepository = $tileRepository;
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
    public function create(array $attributes)
    {
        $this->tile = $this->tileRepository->find($attributes['tile_id']);

        $this->previousTurn = $this->game->lastTurn;

        $turn = $this->game->turns()->create(array_merge([
            'player_id' =>  $this->getPlayer()->id,
            'order' => $this->nextOrder(),
            'left_pile_ends_in' => $this->getLeftPileEnding($attributes['side']),
            'right_pile_ends_in' => $this->getRightPileEnding($attributes['side']),
        ], $attributes));

        SetUpNextTurn::dispatch($turn);

        return $turn;
    }

    /**
     * gets the pile
     *
     * @param string $side
     *
     * @return void
     */
    private function getLeftPileEnding(string $side = null)
    {
        /**
         * this means that it is the first turn therefore both of the numbers are valid
         */
        if (!$this->previousTurn) {
            return $this->tile->left_side;
        }

        if ($side !== 'left') {
            return $this->previousTurn->left_pile_ends_in;
        }

        return  $this->previousTurn->left_pile_ends_in === $this->tile->left_side ? $this->tile->right_side : $this->tile->left_side;
    }

    /**
     *
     *
     * @param string $side
     *
     * @return int
     */
    private function getRightPileEnding(string $side = null)
    {

        /**
         * this means that it is the first turn therefore both of the numbers are valid
         */
        if (!$this->previousTurn) {
            return $this->tile->right_side;
        }
        if ($side !== 'right') {
            return $this->previousTurn->right_pile_ends_in;
        }

        return  $this->previousTurn->right_pile_ends_in === $this->tile->left_side ? $this->tile->right_side : $this->tile->left_side;
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

    /**
     * Gets the next turn order
     *
     * @return int
     */
    private function nextOrder()
    {
        return $this->game->turns()->count() + 1;
    }
}
