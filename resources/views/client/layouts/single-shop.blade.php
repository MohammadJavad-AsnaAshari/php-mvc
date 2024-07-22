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
                    <h5 class="text-success">{{ $product->likes }}</h5>

                    <h6 class="text-uppercase mt-4"><i class="fa fa-ticket"></i> Description : </h6>
                    <p>{{ $product->description }}</p>

                    <h6 class="text-uppercase mt-4"><i class="fa fa-archive"></i> Specification : </h6>
                    <p>{{ $product->specification }}</p>

                    <h6 class="text-uppercase mt-4"><i class="fa fa-folder-open"></i> Categories : </h6>
                    <p>{{ $product->categories }}</p>

                    <h6 class="text-uppercase mt-4"><i class="fa fa-dollar"></i> Price : </h6>
                    <h5 class="text-success">{{ $product->price }} $</h5>

                    <h6 class="text-uppercase mt-4"><i class="fa fa-calendar"></i> Created At : </h6>
                    <p>{{ $product->created_at }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="btn-box">
        <div class="pr-2">
            <a href="#" class="btn btn-success"
               style="background-color: #28a745; border-color: #28a745; color: #fff;
              transition: background-color 0.3s, border-color 0.3s, color 0.3s;"
               onmouseover="this.style.backgroundColor='#fff'; this.style.borderColor='#28a745'; this.style.color='#28a745';"
               onmouseout="this.style.backgroundColor='#28a745'; this.style.borderColor='#28a745'; this.style.color='#fff';">
                Purchase Now
            </a>
        </div>
        @if(auth()->user())
            @if(auth()->user()->likesPost($product->id))
                <form action="/shop/{{ $product->id }}/unlike" method="POST">
                    <button type="submit" class="fw-light nav-link fs-6">
                        <span class="fa fa-heart me-1"></span>
                        {{ $product->likes }}
                    </button>
                </form>
            @else
                <form action="/shop/{{ $product->id }}/like" method="POST">
                    <button type="submit" class="fw-light nav-link fs-6">
                        <span class="fa fa-heart-o me-1"></span>
                        {{ $product->likes }}
                    </button>
                </form>
            @endif
        @else
            <a href="/auth/login" class="fw-light nav-link fs-5">
                <i class="fa fa-heart-o"></i>
                {{ $product->likes }}
            </a>
        @endif
    </div>

    <div class="btn-box text-center mt-5">
        <a href="/shop" class="btn btn-primary">
            View All Products
        </a>
    </div>
</section>

<section class="shop_section layout_padding py-5">
    <div class="container">
        <div class="row mt-5">
            <div class="col-12 col-md-6">
                @if(auth()->user())
                    <div class="detail-box comment-box">
                        <h6 class="text-uppercase"><i class="fa fa-comments"></i> Add Comment : </h6>
                        <form action="/shop/{{ $product->id }}/comments" method="POST">
                            <textarea name="comment" class="form-control" rows="5" required></textarea>
                            <button type="submit" class="btn btn-primary mt-3">Submit Comment</button>
                        </form>
                    </div>
                @else
                    <p class="text-center">Please <a href="/auth/login">login</a> to add a comment.</p>
                @endif
            </div>
            <div class="col-12 col-md-6">
                <div class="detail-box comments-box">
                    <h6 class="text-uppercase mb-3"><i class="fa fa-comments"></i> Comments : </h6>
                    <div class="comments-list">
                        @foreach($comments as $comment)
                            <p><strong>{{ $comment->user_name }}:</strong> {{ $comment->comment }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
