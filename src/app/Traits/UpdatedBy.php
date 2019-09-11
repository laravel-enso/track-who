<?php

namespace LaravelEnso\TrackWho\app\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\Relation;

trait UpdatedBy
{
    protected static function bootUpdatedBy()
    {
        self::creating(function ($model) {
            if (Auth::user()) {
                $model->updated_by = Auth::user()->id;
            }
        });

        self::updating(function ($model) {
            if (Auth::user()) {
                $model->updated_by = Auth::user()->id;
            }
        });
    }

    public function updatedBy() : Relation
    {
        return $this->belongsTo(
            config('auth.providers.users.model'), 'updated_by'
        );
    }
}
