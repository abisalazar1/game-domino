<?php

namespace App;

use Illuminate\Support\Facades\DB;
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

    /**
     * Sum of all tiles
     *
     * @return int
     */
    public function tileSum()
    {
        return $this->tiles()->sum(DB::raw('tiles.left_side + tiles.right_side'));
    }
}
