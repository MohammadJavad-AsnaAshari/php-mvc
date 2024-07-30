@component('admin.layouts.content', ['title' => 'Order Details'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item"><a href="/user-panel/orders">Orders</a></li>
        <li class="breadcrumb-item active" aria-current="page">Order Details</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Order Show</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Product Image</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            @php
                                $totalPrice += $product->price * $product->quantity;
                            @endphp
                            <tr>
                                <td style="vertical-align: middle;">{{ $product->id }}</td>
                                <td style="vertical-align: middle;">
                                    <a href="/shop/{{ $product->id }}">
                                        {{ $product->name }}
                                    </a></td>
                                <td style="vertical-align: middle;">
                                    <img src="/storage/app/product/{{ $product->image }}" alt="{{ $product->name }}"
                                         style="max-width: 100px; max-height: 100px;">
                                </td>
                                <td style="vertical-align: middle;">{{ $product->price }} $</td>
                                <td style="vertical-align: middle;">{{ $product->quantity }}</td>
                                <td style="vertical-align: middle;">{{ $product->price * $product->quantity }} $</td>
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
    <br>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5>Total Price: <strong>{{ $totalPrice }} $</strong></h5>
                    @if( $order->status === 'unpaid')
                        <form action="/payment" method="POST" style="display:inline;">
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <button type="submit" class="btn btn-success">Mark as Paid</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endcomponent
