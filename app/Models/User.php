<?php

namespace App\Models;

use App\Notifications\userRegisteredNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Cmgmyr\Messenger\Traits\Messagable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, Messagable;


    public $passw;
    public $mail;

    public const ROLE_DOC = 'ROLE_DOCTOR';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login',
        'name',
        'email',
        'password',
        'roles'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'jsonData' => 'array',
        'roles' => 'array'
    ];

    public static function getAvailableLogin()
    {
        for ($i = 0; $i < 1000; $i++) {
            $rand = sprintf("%06d", mt_rand(100000, 999999));
            if (!User::whereLogin($rand)->exists()) {
                return $rand;
            }
        }
    }

    /**
     * @param mixed ...$roles
     * @return bool
     */
    public function hasRole(...$roles)
    {
        foreach ($roles as $role) {
            if (in_array($role, $this->roles)) {
                return true;
            }
        }
        return false;
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->roles)) {
                $user->roles = ['ROLE_USER'];
            }
        });

//        static::created(function ($user) {
//            if (!empty($user->email)) {
//                $user->notify(new userRegisteredNotification($user));
//            }
//        });
    }

    public function routeNotificationForMail($notification)
    {
        return $this->mail;
    }

    public function scopeDoctors(Builder $query)
    {
        $query->whereJsonContains('roles', 'ROLE_DOCTOR');
    }

    public function patients()
    {
        return $this->hasMany(UserDoctor::class, 'doctor_id', 'id');
    }

    public function doctors()
    {
        return $this->hasManyThrough(User::class, UserDoctor::class, 'user_id', 'id', 'id', 'doctor_id');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'user_id', 'id');
    }
}
