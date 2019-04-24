<?php

namespace LaravelEnso\TrackWho\app\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;

trait CreatedBy
{
    protected static function bootCreatedBy()
    {
        self::creating(function ($model) {
            if (auth()->user()) {
                $model->created_by = auth()->user()->id;
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
