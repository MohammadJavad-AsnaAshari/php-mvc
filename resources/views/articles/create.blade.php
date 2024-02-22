@extends('layouts.master')
@section('title', 'Article, Create')

@section('body')

    <h2>{{$title}}</h2>

    <h5>
        @if($auth)
            <span>You're login!</span>
        @else
            <span>You're not login!</span>
        @endif
    </h5>

    <form action="/article/create" method="POST">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required placeholder="Enter you title">

        <button type="submit">Create Article</button>
    </form>

@endsection