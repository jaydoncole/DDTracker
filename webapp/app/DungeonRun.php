<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DungeonRun extends Model
{
    public $timestamps = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function($model) {
            $model->run_time = $model->freshTimestamp();

        });
    }
}
