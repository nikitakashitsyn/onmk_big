<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Exam
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Exam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Exam query()
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Exam whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Exam extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tests()
    {
        return $this->hasMany(ExamData::class, 'exam_id', 'id');
    }

    public function pack()
    {
        return $this->hasOne(TestPack::class, 'id', 'test_pack_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getResultAttribute()
    {
        return $this->tests->sum('points');
    }

    public function getTotalAttribute()
    {
        return count($this->tests);
    }

    public function getPenaltyPointsAttribute()
    {
        return $this->tests->sum('penalty_points');
    }

    public function getElapsedTimeAttribute()
    {
        return ($this->tests->sum('elapsed_time'));
    }

}
