<?php

namespace App\Rules;

use App\User;
use App\Repositories\PlayerRepository;
use Illuminate\Contracts\Validation\Rule;

class MustHaveInHand implements Rule
{
    /**
     * Gameid
     *
     * @var int
     */
    protected $gameId;

    /**
     * Current USer
     *
     * @var User
     */
    protected $currentUser;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $gameId, User $currentUser)
    {
        $this->gameId = $gameId;
        $this->currentUser = $currentUser;
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
        return resolve(PlayerRepository::class)->checkPlayersHandForTile($this->gameId, $this->currentUser->id, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Sorry, you must have tile in hand.';
    }
}
