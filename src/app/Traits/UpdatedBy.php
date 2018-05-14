<?php

namespace LaravelEnso\TrackWho\app\Traits;

trait UpdatedBy
{
    protected static function bootUpdatedBy()
    {
        self::creating(function ($model) {
            $model->updated_by = auth()->user()->id;
        });

        self::updating(function ($model) {
            $model->updated_by = auth()->user()->id;
        });
    }

    public function updatedBy()
    {
        return $this->belongsTo(
            config('auth.providers.users.model'),
            'updated_by'
        );
    }
}
