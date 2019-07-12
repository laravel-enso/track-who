<?php

namespace LaravelEnso\TrackWho\app\Http\Resources;

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
            'name' => $this->person->name,
            'appellative' => $this->person->appellative,
        ];
    }
}
