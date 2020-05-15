<?php

namespace App\Rules;

use App\Repositories\GameRepository;
use App\Repositories\TileRepository;
use App\Repositories\TurnRepository;
use Illuminate\Contracts\Validation\Rule;

class TileMustHaveOneOfTheNumbers implements Rule
{

    /**
     * Game ID
     *
     * @var int
     */
    protected $gameId;

    /**
     * Tile ID
     *
     * @var int
     */
    protected $tileId;

    /**
     * TurnRepository
     *
     * @var TurnRepository
     */
    protected $repository;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $gameId, int $tileId)
    {
        $this->gameId = $gameId;
        $this->tileId = $tileId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->repository = resolve(TurnRepository::class);
        
        if (!$this->repository->hasBeenPlayedYet($this->gameId)) {
            return true;
        }

        $tile = resolve(TileRepository::class)->find($this->tileId);

        return $this->repository->getLastTurnByGameId($this->gameId)->canAcceptTile($tile, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Cannot play that tile.';
    }
}
