<?php

namespace App\Rules;

use App\User;
use App\Repositories\GameRepository;
use Illuminate\Contracts\Validation\Rule;

class MustBeUsersTurn implements Rule
{

    /**
     * GameID
     *
     * @var int
     */
    protected $gameId;

    /**
     * CurrentUser
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
        return resolve(GameRepository::class)->find($this->gameId)->current_turn === $this->currentUser->id;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Sorry, it is not your turn.';
    }
}
