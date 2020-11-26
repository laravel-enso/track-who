<?php

namespace LaravelEnso\TrackWho\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

trait DeletedBy
{
    public static function bootDeletedBy()
    {
        self::deleting(fn ($model) => $model->setDeletedBy());
    }

    public function deletedBy(): Relation
    {
        $userModel = Config::get('auth.providers.users.model');

        return $this->belongsTo($userModel, 'deleted_by');
    }

    private function setDeletedBy()
    {
        if (! Auth::check()) {
            return;
        }

        $events = $this->getEventDispatcher();

        tap($this)->unsetEventDispatcher()
            ->forceFill(['deleted_by' => Auth::id()] + $this->getOriginal())
            ->save();

        $this->setEventDispatcher($events);
    }
}
