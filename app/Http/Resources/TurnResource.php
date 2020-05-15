<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TurnResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'order' => $this->order,
            'side' => $this->side,
            'tile' => new TileResource($this->tile),
            'player' => new PlayerResource($this->player),
            'left_pile_ends_in' => $this->left_pile_ends_in,
            'right_pile_ends_in' => $this->right_pile_ends_in,
        ];
    }
}
