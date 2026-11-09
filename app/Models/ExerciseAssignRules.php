<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseAssignRules extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'jsonData' => 'json',
    ];

    public function sourceName()
    {
        if (isset($this->jsonData['source_cat']) && isset($this->jsonData['source_el'])) {
            return IntroTest::getText($this->jsonData['source_cat'] , $this->jsonData['source_el']) ;
           // return TestGroup::find($this->jsonData['target'])->name ?? null;
        }
    }


    public function targetName()
    {
        if (isset($this->jsonData['target'])) {
            return TestGroup::find($this->jsonData['target'])->name ?? null;
        }
    }
}
