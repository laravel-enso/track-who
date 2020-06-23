<?php

namespace LaravelEnso\TrackWho\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

trait UpdatedBy
{
    public static function bootUpdatedBy()
    {
        self::creating(fn ($model) => $model->setUpdatedBy());

        self::updating(fn ($model) => $model->setUpdatedBy());
    }

    public function updatedBy(): Relation
    {
        $userModel = Config::get('auth.providers.users.model');

        return $this->belongsTo($userModel, 'updated_by');
    }

    private function setUpdatedBy()
    {
        if (Auth::check()) {
            $this->updated_by = optional(Auth::id());
        }
    }
}
