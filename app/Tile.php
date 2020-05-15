<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tile extends Model
{
    /**
     * Allows mass asssignment
     *
     * @var array
     */
    protected $fillable = [
        'left_side',
        'right_side'
    ];


    /**
     *
     *
     * @return bool
     */
    public function isPair()
    {
        return $this->left_side === $this->right_side;
    }
}
