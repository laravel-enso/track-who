<?php

namespace LaravelEnso\TrackWho\App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrackWho extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'avatarId' => $this->relationLoaded('avatar')
                ? $this->avatar->id
                : null,
            'name' => $this->relationLoaded('person')
                ? $this->person->name
                : null,
            'appellative' => $this->relationLoaded('person')
                ? $this->person->appellative
                : null,
        ];
    }
}
