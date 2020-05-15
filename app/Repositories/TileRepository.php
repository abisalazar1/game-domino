<?php

namespace App\Repositories;

use App\Tile;

class TileRepository extends Repository
{
    /**
     * TileRepository Constructor
     *
     * @param Tile $tile
     */
    public function __construct(Tile $tile)
    {
        $this->model = $tile;
    }
}
