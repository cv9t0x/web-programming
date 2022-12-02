@extends('layout.app_layout')

@section('title')
    Bindings
@endsection

@section('app-content--inner')
    <div class="title">Bindings</div>
    <div class="bindings-container">
        <section class="bindings-list">
            @if ($bindings_data)
                @foreach ($bindings_data as $binding)
                    @php
                        $form_url_delete = '/app/bindings/remove/'. $binding['id'];
                        $form_url_edit = '/app/bindings/edit/' . $binding['id'];
                    @endphp
                    <div class="binding-block">
                        <form action="{{$form_url_edit}}" method="POST">
                            @csrf
                            <div class="binding-info-block">
                                <div class="binding-info-block--name">Binding: {{$binding['name']}}</div>
                                @if (array_key_exists('repeated', $binding))
                                    @if ($binding['repeated'])
                                        <div class="binding-info-block--warning">Password for this binding repeats {{$binding['repeated']}} times!</div>
                                    @endif
                                @endif
                                <div class="binding-password-block">
                                    <div class="collapse-button-password">Show Password</div>
                                    <div class="binding-password-block--password none">{{$binding['password']}}</div>
                                </div>
                                <div class="collapse-button">Edit</div>
                            </div>
                            <div class="binding-edit-block none">
                                <label>
                                    <div class="binding-edit-block--name">Binding name</div>
                                    @error('name')
                                        <div>{{$message}}</div>
                                    @enderror
                                    <input type="text" name="name" value="{{$binding['name']}}">
                                </label>
                                <label>
                                    <div class="binding-edit-block--old-password">Old password</div>
                                    @error('old_password')
                                        <div>{{$message}}</div>
                                    @enderror
                                    <input type="password" name="old_password">
                                </label>
                                <label>
                                    <div class="binding-edit-block--new-password">New password</div>
                                    @error('password')
                                        <div>{{$message}}</div>
                                    @enderror
                                    <input type="password" name="password">
                                </label>
                                <button class="submit-button" type="submit">Save binding</button>
                            </div>
                        </form>
                        <form action="{{$form_url_delete}}" method="POST">
                            @csrf
                            <button class="submit-button" type="submit">Delete binding</button>
                        </form>
                    </div>
                @endforeach
            @else
                <div>You haven't created any bindings yet!</div>
            @endif
        </section>
        <section class="bindings-creation">
            <h1 class="title">Here you can create new binding!</h1>
            <form method="POST" action="/app/bindings/create">
                @csrf
                <label>
                    <div>Binding name:</div>
                    @error('name')
                        <div>{{$message}}</div>
                    @enderror
                    <input type="text" name="name" value="{{old('name')}}">
                </label>
                <label>
                    <div>Binding password:</div>
                    @error('password')
                        <div>{{$message}}</div>
                    @enderror
                    <input type="password" name="password" >
                </label>
                <button class="submit-button" type="submit">Create</button>
            </form>
            @error('create-binding-error')
                <div>{{$message}}</div>
            @enderror
        </section>
    </div>
@endsection
