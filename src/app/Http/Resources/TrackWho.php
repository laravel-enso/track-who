<?php

namespace LaravelEnso\TrackWho\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use LaravelEnso\Helpers\app\Classes\ResourceAttributeMapper;

class TrackWho extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'avatarId' => $this->whenLoaded('avatar', $this->avatar->id),
        ] +
        (new ResourceAttributeMapper(
            $this,
            config('enso.trackWho.resource')
        ))->get();
    }
}
