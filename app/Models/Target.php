<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Target extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'description', 'start_date', 'end_date', 'department_id', 'author_id', 'status',
    ];

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
        return $this->belongsToMany(Quarter::class, 'target_quarters')
            ->withTimestamps()
            ->withTrashed();
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
