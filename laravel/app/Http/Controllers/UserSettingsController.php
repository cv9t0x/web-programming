<?php

namespace App\Http\Controllers;

use App\Models\UserSettings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Services\UserSettingsService;

class UserSettingsController extends Controller
{

    protected $settings_service;

    public function __construct(UserSettingsService $settings_service)
    {
        $this->settings_service = $settings_service;
    }

    public function render_settings() {
        $settings = UserSettings::where('user_id', Auth::user()['id'])->first()->toArray();
        $remember = boolval(Auth::user()['remember_token']);
        $settings_data = [
            'settings_data' => array_merge($settings, ['remember' => $remember])
        ];

        return $this->render_page('pages.settings', $settings_data);
    }

    public function edit_user_settings(Request $request) {
        $user = Auth::user();
        $remember_token = $request->input('remember_me') ? Str::random(60) : null;

        $user->setRememberToken($remember_token);
        $user->save();

        $user_settings = UserSettings::where('user_id', $user['id'])->first();
        $translated_user_settings = $this->settings_service->translate_user_settings($request->toArray());
        $user_settings->fill($translated_user_settings);

        if (!$user_settings->save()) {
            return redirect('/app/settings');
        } else {
            return redirect('/app/settings')->withErrors([
                'edit-settings-error' => 'Oops! Error occured while trying to edit user settings!'
            ])->withInput();
        }
    }
}
