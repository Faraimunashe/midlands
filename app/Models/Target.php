<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Target extends Model
{
    use SoftDeletes;

    public function milestones()
    {
        return $this->hasMany(Milestone::class);
    }

    public function progress()
    {
        return $this->morphMany(Progress::class, 'progressable');
    }

    public function quarters()
    {
        return $this->belongsToMany(Quarter::class, 'target_quarters');
    }
}
