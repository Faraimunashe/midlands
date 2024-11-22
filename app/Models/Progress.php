<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Progress extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'progressable_type',
        'progressable_id',
        'mda_id',
        'progress_percent',
        'progress_description',
        'is_approved',
    ];

    public function progressable()
    {
        return $this->morphTo();
    }

    public function evidence()
    {
        return $this->morphMany(Evidence::class, 'evidenceable');
    }
}
