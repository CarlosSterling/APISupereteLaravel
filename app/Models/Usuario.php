<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Usuario extends Model
{
    protected $table = 'usuarios';

    protected $fillable = [

        'password',
        'username',
        'first_name',
        'last_name',
        'email',
        'rol',
    ];

    public function setPasswordAttribute($value)
    {

        $this->attributes['password'] = Str::startsWith($value, '$2y$')
            ? $value
            : bcrypt($value);
    }
}
