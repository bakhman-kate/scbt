<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name',
        'name',
        'middle_name',
        'bd',
        'access_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * @return false|string
     */
    public function getBirthday()
    {
        return date(env('DEFAULT_DATE_FORMAT', 'Y-m-d H:i:s'), strtotime($this->bd));
    }

    /**
     * @return false|string
     */
    public function getCreatedDate()
    {
        return date(env('DEFAULT_DATE_FORMAT', 'Y-m-d H:i:s'), strtotime($this->created_at));
    }

    /**
     * @return string
     */
    public function getFIO(): string
    {
        return trim($this->last_name . ' '. $this->name . ' ' . $this->middle_name);
    }

    /**
     * @return bool
     */
    public function getActive(): bool
    {
        return (bool) $this->active;
    }

}
