@component('admin.layouts.content', ['title' => 'Products'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Products</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Products Index</h3>

                    <div class="card-tools d-flex">
                        <div class="btn-group-sm" style="margin-right: 1rem;">
                            <a href="/admin-panel/products/create" class="btn btn-info">Create New Product</a>
                        </div>

                        <form action="">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                       placeholder="Search here...">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="bi bi-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Categories</th>
                            <th>Description</th>
                            <th>Specification</th>
                            <th>Image</th>
                            <th>Price</th>
                            <th>Likes</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        @foreach($products as $product)
                            <tr>
                                <td style="vertical-align: middle;">{{ $product->id }}</td>
                                <td style="vertical-align: middle;">
                                    <a href="/shop/{{ $product->id }}">
                                        {{ $product->name }}
                                    </a>
                                </td>
                                <td>{{ $product->categories }}</td>
                                <td style="vertical-align: middle;">{{ $product->description }}</td>
                                <td style="vertical-align: middle;">{{ $product->specification }}</td>
                                <td style="vertical-align: middle;">
                                    <img src="/storage/app/product/{{ $product->image }}" alt="{{ $product->name }}"
                                         style="max-width: 100px; max-height: 100px;">
                                </td>
                                <td style="color: green; vertical-align: middle;">{{ $product->price }} $</td>
                                <td style="color: orangered; vertical-align: middle;">
                                    @if($product->likes == 0)
                                        <i class="bi bi-heart"></i>
                                    @else
                                        <i class="bi bi-heart-fill"></i>
                                    @endif
                                    {{ $product->likes }}
                                </td>
                                <td style="vertical-align: middle;">{{ $product->created_at }}</td>

                                <td>
                                    <div style="display: flex; flex-direction: row; justify-content: center; align-items: center; height: 100px;">
                                        <a href="/admin-panel/products/edit/{{ $product->id }}"
                                           class="btn btn-sm btn-primary"
                                           style="margin-right: 10px; align-self: center;">
                                            edit
                                        </a>

                                        <form action="/admin-panel/products/delete" class="delete-form" method="POST">
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button class="btn btn-sm btn-danger" style="align-self: center;">
                                                delete
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

@endcomponent