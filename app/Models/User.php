<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property string name
 * @property string email
 * @property string image
 * @property integer id
 * @property bool is_owner
 * @property bool is_admin
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_owner',
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
        'is_owner' => 'boolean',
        'is_admin' => 'boolean',
    ];

    public function setPasswordAttribute($plainTextPassword) {
        $this->attributes['password'] = Hash::make($plainTextPassword);
    }

    public function getImageAttribute() {
        $image = $this->attributes['image'];
        if (isset($image)) {
            return url($image);
        }
        return $image;
    }

    public function restaurants() {
        return $this->hasMany(Restaurant::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }
}
