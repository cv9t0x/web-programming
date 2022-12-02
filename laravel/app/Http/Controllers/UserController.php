<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $user_service;

    public function __construct(UserService $user_service) {
        $this->user_service = $user_service;
    }

    public function render_main() {
        $user_data = [
            'name' => Auth::user()['name'],
            'email' => Auth::user()['email']
        ];

        return $this->render_page('pages.main', $user_data);
    }

    public function edit_user(Request $request) {
        $user = Auth::user();

        $validator = Validator::make($request->all(), $this->user_service->generate_rules('edit'));

        if ($validator->fails()) {
            redirect('pages.main')->withErrors($validator)->withInput();
        }
        //TODO: Fill new userData

        if ($user->save()) {
            redirect('pages.main')->withErrors([
                'edit_user_error' => 'Oops! Error occurred!'
            ])->withInput();
        } else {
            redirect('pages.main');
        }
    }
}
