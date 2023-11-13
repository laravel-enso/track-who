<?php

namespace LaravelEnso\TrackWho\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

trait CreatedBy
{
    public static function bootCreatedBy()
    {
        self::creating(fn ($model) => $model->setCreatedBy());
    }

    public function createdBy(): Relation
    {
        $userModel = Config::get('auth.providers.users.model');

        return $this->belongsTo($userModel, 'created_by');
    }

    private function setCreatedBy()
    {
        if (Auth::check()) {
            $this->fill(['created_by' => Auth::id()]);
        }
    }
}
