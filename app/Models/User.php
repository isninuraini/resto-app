<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'iduser';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'namauser',
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];
}
