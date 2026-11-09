<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class UserTest extends Model
{
    use HasFactory;

    protected $table = 'users_tests';
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function pack()
    {
        return $this->hasOne(TestPack::class, 'id', 'test_pack_id');
    }

    public static function reassign()
    {
        if ($user = Auth::user()) {
            foreach (TestPack::all() as $testpack) {
                if (!empty($testpack->assign) && !empty($user->jsonData['results'])) {

//                    dd($testpack->attributes,$user->jsonData['results']);

                    foreach ($user->jsonData['results'] as $key => $val) {

                        if(isset($testpack->assign[$key]) && $testpack->assign[$key] == $val){

                            //dd('yea;');
                            self::assignPack($user->id, $testpack->id);
                        }

                        //dd($key,$val);
                        //dd($user->jsonData['results'],$key,$val);
                        //dump($key, $val);
//                        $check = $key . '_' . $val;
//                        if (isset($testpack->assign[$check]) && $testpack->assign[$check] == 1) {
//                            self::assignPack($user->id, $testpack->id);
//                        }
                    }
                }
            }
        }
    }

    public static function assignPack($userId, $packId)
    {
        $exists = UserTest::whereUserId($userId)->whereTestPackId($packId)->exists();
        if (!$exists) {
            UserTest::create([
                'user_id' => $userId,
                'test_pack_id' => $packId,
            ]);
        }
    }
}
