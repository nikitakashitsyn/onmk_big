<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TestPackTest extends Model
{
    use HasFactory;

    protected $table  = 'test_packs_tests';

    public function test()
    {
        return $this->hasOne(Test::class, 'id', 'test_id');
    }

}
