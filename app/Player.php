<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    /**
     * mass assignment
     *
     * @var array
     */
    protected $fillable = [
        'game_id',
        'user_id',
        'position'
    ];

    /**
     * BelongsTO
     *
     * @return belongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * BelongsTO
     *
     * @return belongsTo
     */
    public function tiles()
    {
        return $this->belongsToMany(Tile::class);
    }
}
