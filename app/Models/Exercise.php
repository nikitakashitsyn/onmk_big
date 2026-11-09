<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'visible' => 'boolean'
    ];

    public function assignRules()
    {
        return $this->hasMany(ExerciseAssignRules::class, 'exercise_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->whereVisible(true);
    }

    public function attempts()
    {
        return $this->hasMany(Exam::class,'exercise_id','id');
    }
}
