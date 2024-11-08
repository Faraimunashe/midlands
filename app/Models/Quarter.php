<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quarter extends Model
{
    use SoftDeletes;

    public function targets()
    {
        return $this->belongsToMany(Target::class, 'target_quarters');
    }
}
