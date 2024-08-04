@extends('client.layouts.master', ['title' => 'Shop'])

@section('body')
    <div class="hero_area">
        @include('client.layouts.header2')

        <div class="heading-center navbar-collapse innerpage_navbar search-container d-flex justify-content-center align-items-center pt-3"
             id="navbarSupportedContent">

            <!-- Date Order By -->
            @if($dateOrderBy === 'DESC')
                <a href="/shop?products=all&date-order-by=ASC"
                   class="btn nav_search-btn order-btn"
                   style="{{ $dateOrderBy ? 'background-color: #F89CAB; color: #ffffff;' : '' }}">
                    Date ASC
                    <i class="fa fa-sort" aria-hidden="true"></i>
                </a>
            @else
                <a href="/shop?products=all&date-order-by=DESC"
                   class="btn nav_search-btn order-btn"
                   style="{{ $dateOrderBy ? 'background-color: #F89CAB; color: #ffffff;' : '' }}">
                    Date DESC
                    <i class="fa fa-sort" aria-hidden="true"></i>
                </a>
            @endif

            <!-- Price Order By -->
            @if($priceOrderBy === 'DESC')
                <a href="/shop?products=all&price-order-by=ASC"
                   class="btn nav_search-btn order-btn"
                   style="{{ $priceOrderBy ? 'background-color: #F89CAB; color: #ffffff;' : '' }}">
                    Price ASC
                    <i class="fa fa-sort" aria-hidden="true"></i>
                </a>
            @else
                <a href="/shop?products=all&price-order-by=DESC"
                   class="btn nav_search-btn order-btn"
                   style="{{ $priceOrderBy ? 'background-color: #F89CAB; color: #ffffff;' : '' }}">
                    Price DESC
                    <i class="fa fa-sort" aria-hidden="true"></i>
                </a>
            @endif

            <form action="/shop" class="form-inline search-bar d-flex align-items-center rounded-pill bg-light p-2"
                  method="GET">
                <div class="input-group">
                    <input name="search" placeholder="Search for games..."
                           class="form-control search-input rounded-pill" type="text"
                           value="{{ request()->has('search') ? request('search') : '' }}">
                    <button class="btn nav_search-btn" type="submit">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </div>
            </form>
        </div>

    </div>
    <!-- end hero area -->

    <!-- shop section -->
    @include('client.layouts.shop')
    <!-- end shop section -->

    @include('client.layouts.info-section')

@endsection

