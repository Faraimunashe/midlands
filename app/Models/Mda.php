<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mda extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'department_id',
        'user_id',
        'title',
        'firstnames',
        'surname',
        'phone',
        'address',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function targets()
    {
        return $this->hasMany(Target::class);
    }
}
