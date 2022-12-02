@extends('layout.app_layout')

@section('title')
    Main
@endsection

@push('styles')
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
@endpush

@section('app-content--inner')
    <div class="title">Main Page</div>
    <div class="main-container">
        <section class="welcome-app">Lorem ipsum dolor sit amet,
            consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
            Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </section>
        <section class="user-info-user-credentials">
            <div class="field-block">
                <div class="user-info--field">Name: {{$name}}</div>
                <div class="collapse-button">Change</div>
                <form action="/app/main/edit" method="POST" class="user-info--hidden-block none">
                    @csrf
                    @error('name')
                        <div>{{$message}}</div>
                    @enderror
                    <input type="text" name="name" value="{{$name}}">
                    <button class="submit-button" type="submit">Save</button>
                </form>
            </div>
            <div class="field-block">
                <div class="user-info--field">Email: {{$email}}</div>
                <div class="collapse-button">Change</div>
                <form action="/app/main/edit" method="POST" class="user-info--hidden-block none">
                    @csrf
                    @error('email')
                        <div>{{$message}}</div>
                    @enderror
                    <input class="user-info--hidden-block none" type="text" name="email" value="{{$email}}">
                    <button class="submit-button" type="submit">Save</button>
                </form>
            </div>
        </section>
    </div>
@endsection
