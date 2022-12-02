<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AuthService {

    protected $user_service;

    public function __construct(UserService $user_service) {
        $this->user_service = $user_service;
    }

    public function validate_fields(Request $request, $mode) {
        $ruleset = $this->user_service->generate_rules($mode);
        $redirect_path = $mode === 'login' ? 'auth.login' : 'auth.register';

        if (!sizeof($ruleset)) {
            return redirect($redirect_path)->withErrors(["$mode-error" => 'Smth unpredictable has happened!']);
        }

        $validator = Validator::make($request->all(), $ruleset);

        if ($validator->fails()) {
            return redirect($redirect_path)->withErrors($validator)->withInput();
        }

        return null;
    }
}
