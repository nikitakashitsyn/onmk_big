<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class TestPack extends Model
{
    use HasFactory;

    protected $casts = [
        'assign' => 'array'
    ];

    protected $fillable = ['name', 'description', 'timeout', 'max_attempts','assign'];

    public function tests()
    {
        return $this->hasMany(TestPackTest::class, 'test_pack_id', 'id');
    }

    public function attempts()
    {
        return $this->hasMany(Exam::class, 'test_pack_id', 'id')->where('user_id', Auth::id());
    }

}
