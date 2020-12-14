@extends('layouts.base')

@section('header')
@endsection

@section('body')
<h1>No results found</h1>

<label for="search-params">Search parameters</label>
<ul id="search-params">
    @foreach ($query as $k => $v)
    <li>{{ $k }}: {{ $v }}</li>
    @endforeach
</ul>
@endsection
