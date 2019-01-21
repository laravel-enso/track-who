<?php

namespace LaravelEnso\TrackWho\app\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;

trait UpdatedBy
{
    protected static function bootUpdatedBy()
    {
        self::creating(function ($model) {
            $model->updated_by = optional(auth()->user())->id;
        });

        self::updating(function ($model) {
            $model->updated_by = optional(auth()->user())->id;
        });
    }

    public function updatedBy() : Relation
    {
        return $this->belongsTo(
            config('auth.providers.users.model'), 'updated_by'
        );
    }
}
