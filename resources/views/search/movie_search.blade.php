@extends('layouts.base')

@section('header')
@endsection

@section('body')
<form action="api/getMovie" method="GET">
    <fieldset>
        <legend>Movie search</legend>

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
            <label for="title">Title</label>
            <input id="title" type="text" name="title" placeholder="Title" required />
        </div>

        <div>
            <label for="year">Year</label>
            <input id="year" type="number" name="year" placeholder="Year" required />
        </div>

        <div>
            <label for="plot">Plot type</label>
            <select id="plot" name="plot" required>
                <option value="short" selected>short</option>
                <option value="full">full</option>
            </select>
        </div>

        <div>
            <button type="reset">Reset</button>
            <button type="submit">Search</button>
        </div>
    </fieldset>
</form>
@endsection
