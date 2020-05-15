<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
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
            'id' => $this->id,
            'owner' => new UserResource($this->owner),
            'players' => PlayerResource::collection($this->players),
            'turns' => TurnResource::collection($this->turns),
            'tiles_in_pool' => $this->pool_count,
            'tiles_played' => $this->turns_count,
            'players_count' => $this->players_count,
            'current_turn' => new UserResource($this->currentTurn),
            'my_hand' => TileResource::collection($this->currentUserHand())
        ];
    }
}
