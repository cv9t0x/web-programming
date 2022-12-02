<?php

namespace App\Services;

use App\Models\UserSettings;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class BindingsService {

    protected $settings_service;

    public function __construct(UserSettingsService $settings_service)
    {
        $this->settings_service = $settings_service;
    }

    public function calculate_bindings($bindings, $settings) {
        $passwords = array_map(function($row) {
            return [
                'id' => $row['id'],
                'password' => $row['password']
            ];
        }, $bindings);


        if ($settings['warn_repeat_password']) {
            $passwords = $this->check_repeated_passwords($passwords);
        }

        return array_map(function ($pswd_obj) use ($bindings) {
            $index = -1;
            for ($i = 0; $i < sizeof($bindings); $i++) {
                if ($bindings[$i]['id'] === $pswd_obj['id']) {
                    $index = $i;
                }
            }

            $elem = null;

            if ($index >= 0) {
                if (array_key_exists('repeated', $pswd_obj)) {
                    $elem = array_merge($bindings[$index], ['repeated' => $pswd_obj['repeated']]);
                } else {
                    $elem = $bindings[$index];
                }
            }

            $elem['password'] = Crypt::decryptString($elem['password']);

            return $elem;
        }, $passwords);
    }

    private function check_repeated_passwords($bindings) {
        $repeated = [];

        for ($i = 0; $i < sizeof($bindings); $i++) {
            for ($j = 0; $j < sizeof($bindings); $j++) {
                if ($i === $j) continue;
                if (Crypt::decryptString($bindings[$i]['password']) === Crypt::decryptString($bindings[$j]['password'])) {
                    $repeated_index = -1;

                    for ($k = 0; $k < sizeof($repeated); $k++) {
                        if ($repeated[$k]['id'] === $bindings[$i]['id']) {
                            $repeated_index = $i;
                            break;
                        }
                    }

                    if ($repeated_index >= 0) {
                        $repeated[$repeated_index] = [
                            'id' => $repeated[$repeated_index]['id'],
                            'amount' => $repeated[$repeated_index]['amount'] + 1
                        ];
                    } else {
                        array_push($repeated, [
                                'id' => $bindings[$i]['id'],
                                'amount' => 1,
                            ]
                        );
                    }
                }
            }
        }

        for ($i = 0; $i < sizeof($bindings); $i++) {
            $repeated_index1 = -1;
            $repeated_index2 = -1;

            for ($j = 0; $j < sizeof($repeated); $j++) {
                if ($repeated[$j]['id'] === $bindings[$i]['id']) {
                    $repeated_index1 = $j;
                    $repeated_index2 = $i;
                    break;
                }
            }

            $amount1 = 0;
            $amount2 = 0;
            if ($repeated_index1 >= 0) {
                $amount1 = $repeated[$repeated_index1]['amount'];
            }
            if ($repeated_index2 >= 0) {
                $amount2 = $repeated[$repeated_index2]['amount'];
            }

            if ($amount1) {
                $bindings[$repeated_index1] = array_merge($bindings[$repeated_index1], ['repeated' => $amount1]);
            }

            if ($amount2) {
                $bindings[$repeated_index2] = array_merge($bindings[$repeated_index2], ['repeated' => $amount2]);
            }
        }

        return $bindings;
    }

    public function validate_binding(Request $request, $mode = 'creating', $binding = null) {
        $settings = UserSettings::where('user_id', Auth::user()['id'])->get()->toArray()[0];

        $fields_to_validate = [
            'name' => 'required',
            'password' => $settings['warn_password_strength'] ? $this->settings_service->get_password_bindings_validation()[$settings['password_strength']] : 'required',
        ];
        if ($mode === 'editing') {
            $fields_to_validate = array_merge($fields_to_validate, [
                'old_password' => function($attribute, $value, $fail) use($binding) {
                    if (Crypt::decryptString($binding['password']) !== $value) {
                        $fail('Old password is incorrect!');
                    }
                }
            ]);
        }

        $validator = Validator::make($request->toArray(), $fields_to_validate);

        if ($validator->fails()) {
            echo 'failed!';
            return redirect('/app/bindings')->withErrors($validator)->withInput();
        }

        return null;
    }
}
