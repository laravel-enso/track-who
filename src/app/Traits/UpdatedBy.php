<?php

namespace LaravelEnso\TrackWho\app\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;

trait UpdatedBy
{
    protected static function bootUpdatedBy()
    {
        self::creating(function ($model) {
            if (auth()->user()) {
                $model->updated_by = auth()->user()->id;
            }
        });

        self::updating(function ($model) {
            if (auth()->user()) {
                $model->updated_by = auth()->user()->id;
            }
        });
    }

    public function updatedBy() : Relation
    {
        return $this->belongsTo(
            config('auth.providers.users.model'), 'updated_by'
        );
    }
}
