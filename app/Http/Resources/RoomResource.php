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
            // TODO: fill with real data
            /*
            'location' => "Bodley's Court",
            'image' => "https://picsum.photos/200",
            'images' => [
                "https://picsum.photos/200",
                "https://picsum.photos/200?1",
                "https://picsum.photos/200?2",
            ],
            'band' => 6,
            'short_rent' => 1687.12,
            'long_rent' => 1934.33,
            'perks' => [
                'piano', 'set', 'double_bed', 'basin'
            ]
            */
        ];
    }
}
