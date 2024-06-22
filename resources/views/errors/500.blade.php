@extends('errors.layouts.master')

@section('title', 'Error - 500')

@section('content')
    <div class="error-container">
        <h1>Error {{ $error->getCode() }}</h1>
        <p>{{ $error->getMessage() }}</p>
        <a href="/">Home</a>
    </div>
@endsection