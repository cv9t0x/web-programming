<?php

namespace App\Http\Controllers;

use App\Models\Binding;
use App\Models\UserSettings;
use App\Services\BindingsService;
use App\Services\UserSettingsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BindingsController extends Controller
{

    protected $binding_service;
    protected $settings_service;

    public function __construct(BindingsService $binding_service, UserSettingsService $settings_service)
    {
        $this->binding_service = $binding_service;
        $this->settings_service = $settings_service;
    }

    public function render_bindings() {
        $bindings = Binding::where('user_id', Auth::user()['id'])->get()->toArray();
        $settings = UserSettings::where('user_id', Auth::user()['id'])->first()->toArray();

        $bindings = $this->binding_service->calculate_bindings($bindings, $settings);
        $bindings_data = [
            'bindings_data' => $bindings
        ];

        return $this->render_page('pages.bindings', $bindings_data);
    }

    public function create_binding(Request $request) {
        $errors = $this->binding_service->validate_binding($request);
        if ($errors) {
            return $errors;
        }

        $binding = Binding::create(array_merge(['user_id' => Auth::user()['id']], $request->toArray()));

        if (!$binding) {
            return redirect('/app/bindings')->withErrors([
                'create-binding-error' => 'Oops! Something went wrong while creating binding!'
            ]);
        } else {
            return redirect('/app/bindings');
        }
    }

    public function edit_binding(Request $request, $id) {
        $binding = Binding::find($id)->first();
        $errors = $this->binding_service->validate_binding($request, 'editing', $binding);
        if ($errors) {
            return $errors;
        }

        $binding = Binding::find($id)->first();
        $binding->fill($request->toArray());

        if (!$binding->save()) {
            return redirect('/app/bindings')->withErrors([
                'edit-binding-error' => 'Oops! Error occurred while trying to edit binding!'
            ]);
        } else {
            return redirect('/app/bindings');
        }
    }

    public function remove_binding(Request $request, $id) {
        $result = Binding::find($id)->delete();

        if (!$result) {
            return redirect('/app/bindings')->withErrors([
                'delete-binding-error' => 'Oops! Error occurred while trying to delete binding!'
            ]);
        } else {
            return redirect('/app/bindings');
        }
    }
}
