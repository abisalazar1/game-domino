<?php

namespace App\Services\Game;

use App\Game;
use App\Tile;
use Illuminate\Support\Facades\DB;

class StartGameService
{
    /**
     * Game
     *
     * @var Game
     */
    protected $game;

    /**
     * the current first player
     *
     * @var Player
     */
    protected $currentFirstPlayer = null;

    /**
     * Highest Tile id
     *
     * @var int
     */
    protected $highestTileId = null;

    /**
     * Sets the game
     *
     * @param Game $game
     *
     * @return self
     */
    public function setGame(Game $game)
    {
        $this->game = $game;

        return $this;
    }


    /**
     * Starts the game
     *
     * @return void
     */
    public function start()
    {
        $this->assignTilesToPlayers();
    }

    /**
     *
     *
     * @return
     */
    private function assignTilesToPlayers()
    {
        $tiles = Tile::query()->inRandomOrder()->get(['id', 'right_side', 'left_side']);

        $pairTilesIds = $tiles->filter(function ($tile) {
            return $tile->isPair();
        })->sortBy('right_side')->pluck('id')->values();

        $this->game->loadCount('players');

        $this->game->load('players');

        $tiles->pluck('id')->chunk(7)->each(function ($group, $index) use ($pairTilesIds) {
            if ($this->game->players_count >= ($index + 1)) {
                $this->game->players[$index]->tiles()->sync($group);
                $this->setPlayerTurnsOrder($group, $pairTilesIds, $index);
            } else {
                $this->game->pool()->syncWithoutDetaching($group);
            }
        });

        if ($this->currentFirstPlayer->position !== 1) {
            $this->updatePosition();
        }
    }

    /**
     * Sets the current first player
     *
     * @param iterable $group
     * @param iterable $pairTilesIds
     * @param int $index
     *
     * @return void
     */
    private function setPlayerTurnsOrder(iterable $group, iterable $pairTilesIds, int $index)
    {
        $highestTileId = $group->filter(function ($item) use ($pairTilesIds) {
            return $pairTilesIds->contains($item);
        })->max();

        if ($this->highestTileId < $highestTileId) {
            $this->highestTileId = $highestTileId;
            $this->currentFirstPlayer = $this->game->players[$index];

            $this->game->setCurrentTurn($this->currentFirstPlayer->user_id);
        }
    }

    /**
     * Updates the players turn position
     *
     * @param int $position
     *
     * @return void
     */
    private function updatePosition()
    {
        DB::statement("SET @i:=0");

        DB::update("UPDATE players SET players.position=@i:=@i+1 WHERE players.game_id = ? ORDER BY (players.id = ?) DESC, players.position ASC", [
            $this->game->id,
            $this->currentFirstPlayer->id
        ]);
    }
}
