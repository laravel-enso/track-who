<?php

namespace LaravelEnso\TrackWho\App\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;

trait DeletedBy
{
    public static function bootDeletedBy()
    {
        self::deleting(fn ($model) => $model->setDeletedBy());
    }

    public function deletedBy(): Relation
    {
        return $this->belongsTo(
            config('auth.providers.users.model'), 'deleted_by'
        );
    }

    private function setDeletedBy()
    {
        if (! Auth::user()) {
            return;
        }

        $events = $this->getEventDispatcher();

        tap($this)->unsetEventDispatcher()
            ->forceFill(
                ['deleted_by' => Auth::user()->id]
                + $this->getOriginal()
            )->save();

        $this->setEventDispatcher($events);
    }
}
