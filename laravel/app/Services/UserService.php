<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService {

    public function generate_rules($mode) {
        if ($mode === 'login') {
            return array(
                'email' => ['required', 'email'],
                'password' => ['required']
            );
        } else if ($mode === 'registration') {
            return array(
                'email' => ['required', 'email'],
                'password' => ['required', 'confirmed'],
                'name' => ['required']
            );
        } else if ($mode === 'edit') {
            $user = Auth::user();

            if (!$user) {
                return [
                    'edit-user-error' => 'Seems like there\'s no logged user!'
                ];
            }

            return array(
                'email' => ['required', 'email'],
                'old_password' => function($attribute, $value, $fail) use ($user) {
                    $hashed_password = Hash::make($value);
                    if ($user['password'] !== $hashed_password) {
                        $fail('Old password is incorrect!');
                    }
                },
                'password' => ['required', function($attribute, $value, $fail) use ($user) {
                    $hashed_password = Hash::make($value);
                    if ($user['password'] === $hashed_password) {
                        $fail('New password can\'t be the same as old one!');
                    }
                }],
                'name' => ['required']
            );
        }
        return [];
    }
}
