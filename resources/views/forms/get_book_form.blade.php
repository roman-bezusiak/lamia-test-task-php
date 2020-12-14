@extends('layouts.base')

@section('header')
@endsection

@section('body')
<form action="/getBook" method="GET">
    <fieldset>
        @if ($errors->any())
        <div class="error-list-container">
            <ul class="error-list">
                @foreach ($errors->all() as $error)
                <li class="error">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div>
            <label for="isbn">ISBN</label>
            <input
                id="isbn"
                type="text"
                name="isbn"
                placeholder="ISBN"
                minlength="10"
                maxlength="17"
                required />
        </div>

        <div>
            <button type="reset">Reset</button>
            <button type="submit">Search</button>
        </div>
    </fieldset>
</form>
@endsection
