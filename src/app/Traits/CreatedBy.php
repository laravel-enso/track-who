<?php

namespace LaravelEnso\TrackWho\App\Traits;

trait CreatedBy
{
    protected static function bootCreatedBy()
    {
        self::creating(function ($model) {
            $model->created_by = \Auth::user()->id;
        });
    }

    public function createdBy()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'created_by');
    }
}
