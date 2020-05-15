<?php

namespace App\Events;

use App\Turn;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class SetUpNextTurn
{
    use Dispatchable, SerializesModels;

    /**
     * Turn
     *
     * @var App\Turn
     */
    public $turn;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Turn $turn)
    {
        $this->turn = $turn;
    }
}
