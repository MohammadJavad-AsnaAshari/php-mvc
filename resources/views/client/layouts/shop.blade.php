<section class="shop_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>
                Latest Products
            </h2>
        </div>
        <div class="row">
            @if($products)
                @foreach($products as $product)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="box">
                            <a href="/shop/{{ $product->id }}">
                                <div class="img-box">
                                    <img src="{{ $product->getImageURL() }}" alt="">
                                </div>
                                <div class="detail-box">
                                    <h6>{{ $product->name }}</h6>
                                    <h6>Price
                                        <span>{{ $product->price }} $</span>
                                    </h6>
                                </div>
                                <div class="new">
                                    <span>New</span>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="btn-box">
            <a href="">
                View All Products
            </a>
        </div>
    </div>
</section>