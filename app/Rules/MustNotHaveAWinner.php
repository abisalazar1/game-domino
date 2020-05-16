<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MustNotHaveAWinner implements Rule
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
  
        return !$game->winner;
    }
  
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Sorry, Game has eneded';
    }
}
