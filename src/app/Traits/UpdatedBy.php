<?php

namespace LaravelEnso\TrackWho\App\Traits;

trait UpdatedBy
{
    protected static function bootUpdatedBy()
    {
        self::creating(function ($model) {
            $model->updated_by = \Auth::user()->id;
        });

        self::updating(function ($model) {
            $model->updated_by = \Auth::user()->id;
        });
    }

    public function updatedBy()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'updated_by');
    }
}
