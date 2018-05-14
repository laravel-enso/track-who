<?php

namespace LaravelEnso\TrackWho\app\Traits;

trait DeletedBy
{
    protected static function bootDeletedBy()
    {
        self::deleting(function ($model) {
            $model->deleted_by = auth()->user()->id;
        });
    }

    public function deletedBy()
    {
        return $this->belongsTo(
            config('auth.providers.users.model'),
            'deleted_by'
        );
    }
}
