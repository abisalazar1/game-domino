<?php

namespace App;

use App\Tile;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /**
     * mass assignment
     *
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'winner_id',
    ];

    /**
     * Players in the game
     *
     * @return belongsToMany
     */
    public function players()
    {
        return $this->hasMany(Player::class);
    }

    /**
     * Next player turn
     *
     * @param int $id
     *
     * @return void
     */
    public function setCurrentTurn(int $id)
    {
        $this->current_turn = $id;
        
        $this->save();
    }

    /**
     * Next player turn
     *
     * @param int $id
     *
     * @return void
     */
    public function setWinnerId(int $id)
    {
        $this->winner_id = $id;
        
        $this->save();
    }

    /**
    * User
    *
    * @return belongsTo
    */
    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    /**
    * User
    *
    * @return belongsTo
    */
    public function currentTurn()
    {
        return $this->belongsTo(User::class, 'current_turn', 'id');
    }

    /**
     * User
     *
     * @return belongsTo
     */
    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id', 'id');
    }

    /**
     * Gets current users hand
     *
     * @return Collection
     */
    public function currentUserHand()
    {
        return $this->players()->where('user_id', \auth()->user()->id)->with('tiles')->first()->tiles;
    }

    /**
     * User
     *
     * @return belongsTo
     */
    public function pool()
    {
        return $this->belongsToMany(Tile::class);
    }

    /**
     * Adds the players
     *
     * @param array $players
     *
     * @return void
     */
    public function addPlayers(array $players)
    {
        foreach ($players as $index => $player) {
            $this->players()->create([
                'user_id' => $player,
                'position' => $index + 1
            ]);
        }
    }

    /**
     * Turns
     *
     * @return HasMany
     */
    public function turns()
    {
        return $this->hasMany(Turn::class);
    }

    /**
     * Turns
     *
     * @return HasMany
     */
    public function lastTurn()
    {
        return $this->hasOne(Turn::class)->orderBy('order', 'DESC');
    }
}
