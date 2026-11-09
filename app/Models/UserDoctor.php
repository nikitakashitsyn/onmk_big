<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class UserDoctor extends Model
{
    use HasFactory;

    protected $table = 'user_doctor';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function doctor()
    {
        return $this->hasOne(User::class, 'id', 'doctor_id');
    }
}
