<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable  implements JWTSubject

{
    use HasFactory, Notifiable;
    protected $primaryKey = 'id';
    protected $table = 'user';

    public $incrementing = false;
    public $keyType = 'string';

    protected $loginPath = '/login'; // <--- note this

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'name'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getAuthPassword()
    {
        return $this->password;
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
    public function isSuperAdmin() // แอดมิน
    {
        return $this->user_level == "1" ? true : false;
    }

    public function isAdmin() // แอดมิน
    {
        return $this->user_level == "2" ? true : false;
    }

    public function isUser() // ผู้ใช้งานทั่วไป
    {
        return $this->user_level == "3" ? true : false;
    }
}
