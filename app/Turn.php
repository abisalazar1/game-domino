<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turn extends Model
{
    /**
     * Allows mass assignment
     *
     * @var array
     */
    protected $fillable = [
        'player_id',
        'tile_id',
        'side',
        'order',
        'game_id',
        'left_pile_ends_in',
        'right_pile_ends_in'
    ];

    /**
     * BelongTo player
     *
     * @return belongsTo
     */
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * BelongTo game
     *
     * @return belongsTo
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * BelongTo tile
     *
     * @return belongsTo
     */
    public function tile()
    {
        return $this->belongsTo(Tile::class);
    }


    /**
     * checks if can be played
     *
     * @param Tile $tile
     *
     * @return bool
     */
    public function canAcceptTile(Tile $tile, string $side = 'right')
    {
        $tileNumbers = [
            $tile->left_side,
            $tile->right_side
        ];

        $checker = $side === 'left' ?
        $this->left_pile_ends_in :
        $this->right_pile_ends_in;

        return in_array($checker, $tileNumbers);
    }
}
