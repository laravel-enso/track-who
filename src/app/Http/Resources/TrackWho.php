<?php

namespace LaravelEnso\TrackWho\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrackWho extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'avatarId' => $this->whenLoaded('avatar', $this->avatar->id),
        ] + $this->configAttributes();
    }

    private function configAttributes()
    {
        return collect(config('enso.trackWho.resourcePersonAttributes'))
            ->map(function ($attribute) {
                return $this->whenLoaded('person', $this->person->{$attribute});
            })->toArray();
    }
}
