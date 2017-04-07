<?php

namespace LaravelEnso\TrackWho\app\Traits;

trait DeletedBy
{
    protected static function bootDeletedBy()
    {
        self::deleting(function ($model) {
            $model->deleted_by = \Auth::user()->id;

            $model->save();
        });
    }

    public function deleted_by()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'deleted_by');
    }
}
