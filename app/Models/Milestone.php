<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Milestone extends Model
{
    use SoftDeletes;

    public function target()
    {
        return $this->belongsTo(Target::class);
    }

    public function progress()
    {
        return $this->morphMany(Progress::class, 'progressable');
    }
}
