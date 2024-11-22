<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evidence extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'evidenceable_type',
        'evidenceable_id',
        'file_path',
        'file_type',
        'description',
    ];

    public function evidenceable()
    {
        return $this->morphTo();
    }
}
