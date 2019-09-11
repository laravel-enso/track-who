<?php

namespace LaravelEnso\TrackWho\app\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\Relation;

trait CreatedBy
{
    protected static function bootCreatedBy()
    {
        self::creating(function ($model) {
            if (Auth::user()) {
                $model->created_by = Auth::user()->id;
            }
        });
    }

    public function createdBy() : Relation
    {
        return $this->belongsTo(
            config('auth.providers.users.model'), 'created_by'
        );
    }
}
