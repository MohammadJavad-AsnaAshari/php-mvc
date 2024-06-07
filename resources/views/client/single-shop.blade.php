@extends('client.layouts.master', ['title' => $product->name])

@section('body')
    <div class="hero_area">
        @include('client.layouts.header2')
    </div>
    <!-- end hero area -->

    <!-- shop section -->
    @include('client.layouts.single-shop')
    <!-- end shop section -->

    @include('client.layouts.info-section')

@endsection

