@extends('client.layouts.master')

@section('body')
    <div class="hero_area">
        @include('client.layouts.header1')

        <!-- slider section -->
        @include('client.layouts.slider')
        <!-- end slider section -->
    </div>
    <!-- end hero area -->

    <!-- shop section -->
    @include('client.layouts.shop-home')
    <!-- end shop section -->

    <!-- why section -->
    @include('client.layouts.why-us')
    <!-- end why section -->

    <!-- gift section -->
    @include('client.layouts.gift')
    <!-- end gift section -->

    <!-- contact section -->
    @include('client.layouts.contact-us')
    <!-- end contact section -->

    <!-- info section -->
    @include('client.layouts.info-section')
    <!-- end info section -->

@endsection