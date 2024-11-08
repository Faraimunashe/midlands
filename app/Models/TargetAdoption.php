<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TargetAdoption extends Model
{
    use SoftDeletes;

    public function target()
    {
        return $this->belongsTo(Target::class);
    }

    public function adoptingMda()
    {
        return $this->belongsTo(Mda::class, 'adopting_mda_id');
    }

    public function originalMda()
    {
        return $this->belongsTo(Mda::class, 'original_mda_id');
    }
}
