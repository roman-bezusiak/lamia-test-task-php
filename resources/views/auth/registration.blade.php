@extends('layouts.base')

@section('header')
@endsection

@section('body')
<form action="/api/auth/registration" method="POST">
    <fieldset>
        <legend>Registration</legend>

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
            <button type="submit">Register</button>
        </div>
    </fieldset>
</form>

<div>
    <a href="/login">Login</a>
</div>
@endsection
