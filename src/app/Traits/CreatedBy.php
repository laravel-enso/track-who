<?php

namespace LaravelEnso\TrackWho\app\Traits;

trait CreatedBy
{
    protected static function bootCreatedBy()
    {
        self::creating(function ($model) {
            $model->created_by = \Auth::user()->id;
        });
    }

    public function created_by()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'created_by');
    }
}
