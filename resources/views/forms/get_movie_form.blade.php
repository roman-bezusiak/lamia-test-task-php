@extends('layouts.base')

@section('header')
@endsection

@section('body')
<form action="/getMovie" method="GET">
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
    </div>
    <div>
        <button type="reset">Reset</button>
        <button type="submit">Search</button>
    </div>
</form>
@endsection
