@extends('layout.auth_layout')

@section('title')
    Login
@endsection

@section('content-auth--inner')
<div class="login-block">
    <h1 class="login-block--title">Log In</h1>
    @error('login-error')
        <div>{{$message}}</div>
    @enderror
    <form method="POST" action="/auth/login" class="login-form">
        @csrf
        <div class="login-form--form-item">
            <div class="login-form--form-item-name">Email</div>
            @error('email')
                <div>{{$message}}</div>
            @enderror
            <input class="login-form--form-item-input" type="email" required placeholder="email" name="email" value="{{old('email')}}">
        </div>
        <div class="login-form--form-item">
            <div class="login-form--form-item-name">Password</div>
            @error('password')
                <div>{{$message}}</div>
            @enderror
            <input class="login-form--form-item-input" type="password" required placeholder="password" name="password">
        </div>
        <div>
            <input type="checkbox" name="remember">
            <span class="login-form--form-item-name">Remember me</span>
        </div>
        <button class="submit-button" type="submit">Sign in</button>
    </form>
    <div class="login-block--link-block">
        <div>Dont have an account?</div>
        <a href="/auth/register">Sign up</a>
    </div>
</div>
@endsection
