@extends('client.layouts.master', ['title' => 'Cart'])

@section('body')
    <div class="hero-area">
        @include('client.layouts.header2')
    </div>
    <section class="shop_section layout_padding">
        @php
            $totalPrice = 0;
        @endphp
        <div class="container">
            <div class="heading_container heading_center">
                <h2>Cart</h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered m-0">
                                    <thead>
                                    <tr>
                                        <!-- Set columns width -->
                                        <th class="text-center py-3 px-4" style="min-width: 360px;">Product Name</th>
                                        <th class="text-center py-3 px-4" style="min-width: 40px;">Image</th>
                                        <th class="text-right py-3 px-4" style="width: 150px;">Unit Price</th>
                                        <th class="text-center py-3 px-4" style="width: 120px;">Quantity</th>
                                        <th class="text-right py-3 px-4" style="width: 150px;">Total Price</th>
                                        <th class="text-center align-middle py-3 px-0" style="width: 40px;">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- Example row, you can remove this and replace with actual data -->
                                    @foreach($products as $product)
                                        @php
                                            $totalPrice += $product['price'] * $product['quantity'];
                                        @endphp
                                        <tr>
                                            <td class="p-4">
                                                <div class="media align-items-center">
                                                    <div class="media-body">
                                                        <a href="/shop/{{ $product['id'] }}"
                                                           class="d-block text-dark">{{ $product['name'] }}</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle;">
                                                <img src="/storage/app/product/{{ $product['image'] }}"
                                                     alt="{{ $product['name'] }}"
                                                     style="max-width: 100px; max-height: 100px;">
                                            </td>
                                            <td class="text-right font-weight-semibold align-middle p-4">{{ $product['price'] }}
                                                $
                                            </td>
                                            <td class="align-middle p-4">
                                                <form action="/cart/quantity/update" method="POST">
                                                    <input type="hidden" name="id" value="1">
                                                    <!-- Replace with actual product ID -->
                                                    <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                                    <div class="input-group d-flex flex-column align-items-center">
                                                        <div class="btn-group" role="group"
                                                             aria-label="Quantity buttons">
                                                            <input type="number" name="quantity"
                                                                   class="form-control text-center mb-2"
                                                                   value="{{ $product['quantity'] }}" min="1">
                                                        </div>
{{--                                                        <div class="btn-group" role="group" aria-label="Quantity buttons">--}}
{{--                                                            <button type="submit" name="action" value="decrement"--}}
{{--                                                                    class="btn btn-sm btn-secondary">---}}
{{--                                                            </button>--}}
{{--                                                            <button type="submit" name="action" value="increment"--}}
{{--                                                                    class="btn btn-sm btn-secondary">+--}}
{{--                                                            </button>--}}
{{--                                                        </div>--}}
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="text-right font-weight-semibold align-middle p-4">{{ $product['price'] * $product['quantity'] }}
                                                $
                                            </td>
                                            <td class="text-center align-middle px-0">
                                                <form action="/cart/delete" method="POST">
                                                    <!-- Replace with actual product ID -->
                                                    <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        ×
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <!-- End of example row -->
                                    </tbody>
                                </table>
                            </div>
                            <!-- / Shopping cart table -->
                            <div class="d-flex flex-wrap justify-content-between align-items-center pb-4">
                                <div class="float-left">
                                    <form action="/cart/orders" method="POST" id="cart-payment">
                                    </form>
                                    <button onclick="document.getElementById('cart-payment').submit()" type="button"
                                            class="btn btn-lg btn-primary mt-2" id="order-button">
                                        Order
                                    </button>
                                </div>
                                <div class="mt-4"></div>
                                <div class="d-flex">
                                    <div class="text-right mt-4">
                                        <label class="text-muted font-weight-normal m-0">Total Price</label>
                                        <div class="text-large"><strong>{{ $totalPrice }} $</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('client.layouts.info-section')
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var totalPrice = {{ $totalPrice }};
        var orderButton = document.getElementById('order-button');

        if (totalPrice == 0) {
            orderButton.disabled = true;
        }
    });
</script>

<style>
    .table th, .table td {
        vertical-align: middle;
    }

    .table th.text-center, .table td.text-center {
        text-align: center;
    }

    .table th.text-right, .table td.text-right {
        text-align: right;
    }

    .table th.align-middle, .table td.align-middle {
        vertical-align: middle;
    }

    .table th.py-3, .table td.py-3 {
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .table th.px-4, .table td.px-4 {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }

    .table th.px-0, .table td.px-0 {
        padding-left: 0;
        padding-right: 0;
    }

    .table .form-control {
        margin-bottom: 0.5rem;
    }

    .table .btn {
        margin-top: 0.5rem;
    }

    .input-group {
        display: flex;
        align-items: center;
    }

    .input-group .btn {
        border-radius: 0;
    }

    .input-group .form-control {
        text-align: center;
        border-radius: 0;
    }
</style>
