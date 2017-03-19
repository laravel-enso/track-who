<?php

namespace LaravelEnso\TrackWho\Traits;

trait CreatedBy
{
    protected static function bootCreatedBy()
    {
        static::creating(function ($model) {
            $model->created_by = \Auth::user()->id;
        });
    }

    public function createdBy()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'created_by');
    }
}
