<?php

namespace App\Rules;

use App\Repositories\GameRepository;
use Illuminate\Contracts\Validation\Rule;

class GameMustHaveTilesInPool implements Rule
{
    /**
       * GameID
       *
       * @var int
       */
    protected $gameId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $gameId)
    {
        $this->gameId = $gameId;
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
        $game = resolve(GameRepository::class)->find($this->gameId);

        $game->loadCount('pool');

        return $game->pool_count;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Sorry, pool is empty.';
    }
}
