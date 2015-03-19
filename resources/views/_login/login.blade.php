@extends('victory.core::layout.master')

@section('body')
    <div class="victory__login-wrapper">
        <div class="victory__login">

            <h1>Login</h1>

            <form method="POST" action="{{ route('victory.auth.login') }}">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}"/>

                <div class="victory__login-form-group">
                    <label class="victory__login-label">Username</label>
                    <input class="victory__login-input" type="text" name="email" value="{{ Request::old('email') }}">
                </div>
                <div class="victory__login-form-group">
                    <lable class="victory__login-label">Password</lable>
                    <input class="victory__login-input" type="password" name="password" value="">
                </div>

                <input class="victory__login-button" type="submit" value="Login">
            </form>
        </div>
    </div>
@stop