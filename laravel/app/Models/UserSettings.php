<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'password_strength',
        'warn_password_strength',
        'warn_repeat_password'
    ];

    public static $init_settings = [
        'password_strength' => 'medium',
        'warn_password_strength' => true,
        'warn_repeat_password' => true,
    ];
}
