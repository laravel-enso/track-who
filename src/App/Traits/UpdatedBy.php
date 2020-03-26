<?php

namespace LaravelEnso\TrackWho\App\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;

trait UpdatedBy
{
    public static function bootUpdatedBy()
    {
        self::creating(fn ($model) => $model->setUpdatedBy());

        self::updating(fn ($model) => $model->setUpdatedBy());
    }

    public function updatedBy(): Relation
    {
        return $this->belongsTo(
            config('auth.providers.users.model'), 'updated_by'
        );
    }

    private function setUpdatedBy()
    {
        if (Auth::check()) {
            $this->updated_by = optional(Auth::user())->id;
        }
    }
}
