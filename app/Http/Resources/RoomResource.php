<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
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
            'number' => $this->number,
            'floor' => $this->floor,
            'available' => $this->available,
            'long_contract' => $this->long_contract,
            'perks' => $this->whenLoaded('perks', function () {
                return PerkResource::collection($this->perks);
            }),
            'band' => $this->band->number,
            'short_rent' => $this->band->short_rent,
            'long_rent' => $this->band->long_rent,
            'location' => $this->location->name,
            'ballot_id' => $this->ballot_id,
            'comments' => $this->whenLoaded('comments')
            // TODO: fill with real data
            /*
            'image' => "https://picsum.photos/200",
            'images' => [
                "https://picsum.photos/200",
                "https://picsum.photos/200?1",
                "https://picsum.photos/200?2",
            ],
            */
        ];
    }
}
