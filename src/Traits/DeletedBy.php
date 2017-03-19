<?php

namespace LaravelEnso\TrackWho\Traits;

trait DeletedBy
{

    protected static function bootDeletedBy()
    {
        static::deleting(function ($model) {

            $model->deleted_by = \Auth::user()->id;

            $model->save();
        });
    }

    public function deletedBy()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'deleted_by');
    }
}
