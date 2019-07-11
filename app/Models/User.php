<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    protected $table = 'user';
    protected $guarded = ['id'];
    protected $hidden = ['password', 'api_key', 'parents', 'left_point', 'right_point', 'remember_token'];

    protected $casts = [
        'enable_link' => 'bool',
        'distort'     => 'bool',
    ];
}
