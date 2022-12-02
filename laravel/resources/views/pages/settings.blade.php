@extends('layout.app_layout')

@section('title')
    Settings
@endsection

@section('app-content--inner')
    <div class="settings-container">
        <div class="title">Settings</div>
        <form method="POST" action="/app/settings/edit" class="settings-form">
            @csrf
            <div class="field-block">
                <label>
                    <span>Warn me about repeated bindings passwords</span>
                    <input type="checkbox" name="warn_repeat_password" {{$settings_data['warn_repeat_password'] ? 'checked': ''}}/>
                </label>
            </div>
            <div class="field-block">
                <label>
                    <span>Warn me about weak binding passwords</span>
                    <input type="checkbox" name="warn_password_strength" {{$settings_data['warn_password_strength'] ? 'checked': ''}}/>
                </label>
            </div>
            <div class="field-block">
                <div class="password-settings-block--strength">
                    <div class="mb-10">Passwords strength:</div>
                    <label>
                        <input type="radio" value="weak" name="password_strength" {{$settings_data['password_strength'] === 'weak' ? 'checked' : ''}}/>
                        <span>Weak</span>
                    </label>
                    <label>
                        <input type="radio" value="medium" name="password_strength" {{$settings_data['password_strength'] === 'medium' ? 'checked' : ''}}/>
                        <span>Medium</span>
                    </label>
                    <label>
                        <input type="radio" value="strong" name="password_strength" {{$settings_data['password_strength'] === 'strong' ? 'checked' : ''}}/>
                        <span>Strong</span>
                    </label>
                </div>
            </div>
            <label>
                <span>Remember Me</span>
                <input type="checkbox" name="remember_me" {{$settings_data['remember'] ? 'checked': ''}}/>
            </label>
            <button class="submit-button" type="submit">Save settings</button>
        </form>
    </div>
@endsection
