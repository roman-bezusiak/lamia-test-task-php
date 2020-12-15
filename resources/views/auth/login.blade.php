@extends('layouts.base')

@section('header')
@endsection

@section('body')
<form id="login-from" action="/api/auth/login" method="POST">
    <fieldset>
        <legend>Login</legend>

        @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div>
            <div>
                <label for="email">Email</label>
                <input id="email" type="email" name="email" placeholder="Email" required />
            </div>

            <div>
                <label for="password">Password</label>
                <input id="password" type="password" name="password" placeholder="Password" required />
            </div>
        </div>

        <div>
            <button type="reset">Reset</button>
            <button id="sumbit-btn" type="submit">Login</button>
        </div>
    </fieldset>
</form>

<div>
    <a href="/api/auth/registration">Register</a>
</div>
@endsection
