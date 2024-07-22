@extends('client.layouts.master', ['title' => 'Categories'])

@section('body')
    <div class="hero_area">
        @include('client.layouts.header2')

        <div class="container layout_padding">
            <div class="heading_container heading_center">
                <h2>Categories</h2>
            </div>
            <div class="row pt-5">
                @foreach($categories as $category)
                    <div class="col-md-4 col-sm-6">
                        <div class="card m-1">
                            <div class="card-body">
                                <h5 class="card-title">{{ $category->name }}</h5>
                                <p class="card-text">{{ $category->description, 100 }}</p>
                                <div class="btn-box">
                                    <a href="/categories/{{ \Illuminate\Support\Str::lower($category->name) }}">View Products</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @include('client.layouts.info-section')

@endsection
