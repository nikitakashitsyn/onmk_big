<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * App\Models\TestGroup
 *
 * @property int $id
 * @property string $name
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Test[] $tests
 * @property-read int|null $tests_count
 * @method static \Illuminate\Database\Eloquent\Builder|TestGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TestGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TestGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|TestGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestGroup whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TestGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TestGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function tests()
    {
        return $this->hasMany(Test::class, 'group_id', 'id');
    }

    public static function getDropDown()
    {
        return DB::table("test_groups")->pluck("name", "id");
    }

    public function getRandomTest($qty = 1)
    {
        return Test::where('group_id', $this->id)->inRandomOrder()->limit($qty)->get();
    }
}
