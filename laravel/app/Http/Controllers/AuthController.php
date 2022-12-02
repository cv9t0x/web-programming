<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Providers\RouteServiceProvider;
use App\Services\UserSettingsService;
use App\Services\AuthService;

class AuthController extends Controller {

    protected $auth_service;
    protected $settings_service;

    public function __construct(AuthService $auth_service, UserSettingsService $settings_service) {
        $this->auth_service = $auth_service;
        $this->settings_service = $settings_service;
    }

    public function render_login() {
        return parent::render_page('pages.login');
    }

    public function render_register() {
        return parent::render_page('pages.register');
    }

    public function authentificate(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $errors = $this->auth_service->validate_fields($request, 'login');
        if ($errors) return $errors;

        $remember = $request->input('remember', false);

        var_dump($remember);

        if (Auth::attempt($credentials, $remember)) {
            return $this->redirect_to_main($request);
        } else {
            return redirect(RouteServiceProvider::LOGIN)->withErrors([
                'login-error' => 'Oops! Smth went wrong!'
            ]);
        }

    }

    public function register(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed'],
            'name' => ['required']
        ]);

        $errors = $this->auth_service->validate_fields($request, 'registration');
        if ($errors) return $errors;

        $remember = $request->input('remember', false);
        $user = User::create($credentials);
        $settings_initialized = $this->settings_service->init_settings($user->toArray()['id']);

        if (!$settings_initialized) {
            if ($this->revert_сreating_object($user)) {
                return redirect(RouteServiceProvider::LOGIN)->withErrors([
                    'registration-error' => 'Oops! Smth went wrong!'
                ]);
            }
        }

        if ($user) {
            if (Auth::login($user, $remember)) {
                return $this->redirect_to_main($request);
            } else {
                return redirect(RouteServiceProvider::LOGIN)->withErrors([
                    'registration-error' => 'Oops! Smth went wrong!'
                ]);
            }
        } else {
            return redirect(RouteServiceProvider::LOGIN)->withErrors([
                'registration-error' => 'Oops! Smth went wrong!'
            ]);
        }
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return redirect('/auth/login');
    }

    private function redirect_to_main(Request $request) {
        $request->session()->regenerate();
        return redirect()->intended('/app/main');
    }

}
