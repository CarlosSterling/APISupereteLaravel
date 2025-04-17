<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
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
}
