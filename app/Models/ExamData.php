<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamData extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'question' => 'json',
        'answer' => 'json'
    ];

    public function test()
    {
        return $this->hasOne(Test::class, 'id', 'test_id');
    }
}
