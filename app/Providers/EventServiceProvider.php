<?php

namespace App\Providers;

use App\Events\SetUpNextTurn;
use App\Listeners\CheckForWinner;
use App\Listeners\RemovePlayedTile;
use App\Listeners\SetNextTurn;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SetUpNextTurn::class => [
            RemovePlayedTile::class,
            SetNextTurn::class,
            CheckForWinner::class
            
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
