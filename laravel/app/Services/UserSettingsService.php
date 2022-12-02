<?php

namespace App\Services;

use App\Models\UserSettings;
use Exception;
use App\Rules\ConsistNumbers;
use App\Rules\MixedCase;
use App\Rules\SpecialCharacters;

class UserSettingsService {

    public function init_settings($user_id) {
        $default_settings = null;

        try {
            $default_settings = UserSettings::create(array_merge(
                UserSettings::$init_settings,
                ['user_id' => $user_id]
            ));
        } catch (Exception $e) {
            return false;
        }

        return !$default_settings ? false : true;
    }

    public function get_password_bindings_validation() {
        return [
            'weak' => ['min:4', 'required', new ConsistNumbers],
            'medium' => ['min:8', 'required', new ConsistNumbers, new MixedCase],
            'strong' => ['min:16', 'required', new ConsistNumbers, new MixedCase, new SpecialCharacters],
        ];
    }

    public function translate_user_settings($settings) {
        if (array_key_exists('warn_password_strength', $settings)) {
            $settings['warn_password_strength'] = $settings['warn_password_strength'] ? 1 : 0;
        } else {
            $settings['warn_password_strength'] = 0;
        }
        if (array_key_exists('warn_repeat_password', $settings)) {
            $settings['warn_repeat_password'] = $settings['warn_repeat_password'] ? 1 : 0;
        } else {
            $settings['warn_repeat_password'] = 0;
        }
        return $settings;
    }
}
