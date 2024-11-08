<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Progress extends Model
{
    use SoftDeletes;

    public function progressable()
    {
        return $this->morphTo();
    }

    public function evidence()
    {
        return $this->morphMany(Evidence::class, 'evidenceable');
    }
}
