<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return false|string
     */
    public function getBirthday()
    {
        return date(env('DEFAULT_DATE_FORMAT', 'Y-m-d H:i:s'), $this->bd);
    }

    /**
     * @return false|string
     */
    public function getCreatedDate()
    {
        return date(env('DEFAULT_DATE_FORMAT', 'Y-m-d H:i:s'), $this->created_at);
    }

    public function getFIO()
    {
        return trim($this->last_name . $this->name . $this->middle_name);
    }

    /**
     * @return bool
     */
    public function getActive()
    {
        return (bool) $this->active;
    }

}
