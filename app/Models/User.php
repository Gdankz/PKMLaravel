<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // Jika primary key bukan 'id'
    protected $primaryKey = 'noRekamMedis';

    // Jika primary key bukan integer
    public $incrementing = false;

    // Jika primary key bukan auto-incrementing
    protected $keyType = 'string';

    protected $fillable = [
        'nama',
        'noRekamMedis',
    ];
}
