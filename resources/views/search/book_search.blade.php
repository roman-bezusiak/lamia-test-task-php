@extends('layouts.base')

@section('header')
@endsection

@section('body')
<form action="api/getBook" method="GET">
    @csrf
    <fieldset>
        <legend>Book search</legend>

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
