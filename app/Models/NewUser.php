<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class NewUser extends Model
{
    protected $fillable = ['user_id', 'is_new'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function updatePassword()
    {
        NewUser::where('user_id', Auth::id())->delete();
    }
}
