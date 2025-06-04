<?php

namespace App\Http\Resources\Album;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'artist_id' => $this->artist_id,
            'name'      => $this->name,
            'image'     => $this->image ?? null,
            'year'      => $this->year,
            'sales'     => $this->sales
        ];
    }
}
