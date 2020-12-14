@extends('layouts.base')

@section('header')
@endsection

@section('body')
<p>Error status code: {{ $error_status }}</p>

@if ($error_message):
<p>Error message: {{ $error_message }}</p>
@endif
@endsection
