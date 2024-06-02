<section class="shop_section layout_padding py-5">
    <div class="container">
        <div class="heading_container heading_center text-center mb-5">
            <h2>
                {{ $product->name }}
            </h2>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="img-box">
                    <img src="{{ $product->getImageURL() }}" alt="Product Image" class="img-fluid">
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="detail-box">
                    <h6 class="text-uppercase"><i class="fa fa-gamepad"></i> Product Name : </h6>
                    <h5>{{ $product->name }}</h5>

                    <h6 class="text-uppercase mt-4"><i class="fa fa-heart"></i> Likes :</h6>
                    <h5 class="text-success">{{ $product->like }}</h5>

                    <h6 class="text-uppercase mt-4"><i class="fa fa-ticket"></i> Description : </h6>
                    <p>{{ $product->description }}</p>

                    <h6 class="text-uppercase mt-4"><i class="fa fa-archive"></i> Specification : </h6>
                    <p>{{ $product->specification }}</p>

                    <h6 class="text-uppercase mt-4"><i class="fa fa-dollar"></i> Price : </h6>
                    <h5 class="text-success">{{ $product->price }} $</h5>

                    <h6 class="text-uppercase mt-4"><i class="fa fa-calendar"></i> Created At : </h6>
                    <p>{{ $product->created_at }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="btn-box">
        <style></style>
        <a href="#" class="btn btn-success" style="background-color: #28a745; border-color: #28a745 !important; color: #fff !important;">
            Purchase Now
        </a>
    </div>

    <div class="btn-box text-center mt-5">
        <a href="/shop" class="btn btn-primary">
            View All Products
        </a>
    </div>
    </div>
</section>
