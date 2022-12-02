@extends('index')

@section('content-app')
    <div class="app-layout-container">
        @include('components.navbar')
        <div class="app-content--inner">
            @yield('app-content--inner')
        </div>
    </div>
@endsection
