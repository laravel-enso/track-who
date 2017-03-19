<?php

namespace LaravelEnso\TrackWho\Traits;

trait UpdatedBy
{

    protected static function bootUpdatedBy()
    {
        static::creating(function ($model) {

            $model->updated_by = \Auth::user()->id;
        });

        static::updating(function ($model) {

            $model->updated_by = \Auth::user()->id;
        });
    }

    public function updatedBy()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'updated_by');
    }
}
