<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Binding extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'password',
        'icon'
    ];

    public function setPasswordAttribute($password) {
        if (trim($password) === '') {
            return;
        }

        $this->attributes['password'] = Crypt::encryptString($password);
    }
}
