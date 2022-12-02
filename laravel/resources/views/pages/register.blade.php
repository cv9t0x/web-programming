@extends('layout.auth_layout')

@section('title')
    Registration
@endsection

@section('content-auth--inner')
<div class="login-block">
    <h1 class="login-block--title">Sign Up</h1>
    @error('registration-error')
        <div>{{$message}}</div>
    @enderror
    <form method="POST" action="/auth/register">
        @csrf
        <div class="login-form--form-item">
            <div class="login-form--form-item-name">Name</div>
            @error('name')
                <div>{{$message}}</div>
            @enderror
            <input class="login-form--form-item-input" type="text" required placeholder="name" name="name" value="{{old('name')}}">
        </div>
        <div class="login-form--form-item">
            <div class="login-form--form-item-name">Email</div>
            @error('email')
                <div>{{$message}}</div>
            @enderror
            <input type="email" required placeholder="email" name="email" value="{{old('email')}}">
        </div>
        <div class="login-form--form-item">
            <div class="login-form--form-item-name">Password</div>
            @error('password')
                <div>{{$message}}</div>
            @enderror
            <input type="password" required placeholder="password" name="password">
        </div>
        <div class="login-form--form-item">
            <div class="login-form--form-item-name">Password confirmation</div>
            @error('password_confirmation')
                <div>{{$message}}</div>
            @enderror
            <input type="password" required placeholder="confirm password" name="password_confirmation">
        </div>
        <button class="submit-button" type="submit">Sign up</button>
        <div class="login-block--link-block">
            <a href="/auth/login">Back</a>
        </div>
    </form>
</div>
@endsection
