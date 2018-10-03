<?php

namespace LaravelEnso\TrackWho\app\Traits;

trait DeletedBy
{
    protected static function bootDeletedBy()
    {
        self::deleting(function ($model) {
            $events = $model->getEventDispatcher();

            tap($model)->unsetEventDispatcher()
                ->forceFill(
                    $model->getOriginal()
                    + ['deleted_by' => optional(auth()->user())->id]
            )->save();

            $model->setEventDispatcher($events);
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
