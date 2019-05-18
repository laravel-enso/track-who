<?php

namespace LaravelEnso\TrackWho\app\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;

trait DeletedBy
{
    protected static function bootDeletedBy()
    {
        self::deleting(function ($model) {
            if (! auth()->user()) {
                return;
            }

            $events = $model->getEventDispatcher();

            tap($model)->unsetEventDispatcher()
                ->forceFill(
                    ['deleted_by' => auth()->user()->id]
                    + $model->getOriginal()
                )->save();

            $model->setEventDispatcher($events);
        });
    }

    public function deletedBy() : Relation
    {
        return $this->belongsTo(
            config('auth.providers.users.model'), 'deleted_by'
        );
    }
}
