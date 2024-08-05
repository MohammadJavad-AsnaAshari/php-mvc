@component('admin.layouts.content', ['title' => 'Orders'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Orders</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Orders</h3>

                    <div class="card-tools d-flex">
                        <div class="btn-group-sm" style="margin-right: 2rem;">
                            <a href="/admin-panel/orders/export/pdf" class="btn btn-danger">Export to PDF</a>
                            <a href="/admin-panel/orders/export/word" class="btn btn-primary">Export to Word</a>
                            <a href="/admin-panel/orders/export/excel" class="btn btn-success">Export to Excel</a>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>User Name</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Total Price</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>
                                    <a href="/user-panel/{{ $order->user_id }}">
                                        {{ $order->user_name }}
                                    </a>
                                </td>
                                <td>{{ $order->status }}</td>
                                <td>{{ $order->created_at }}</td>
                                <td>{{ $order->price }} $</td>
                                <td>
                                    <a href="/admin-panel/orders/{{ $order->id }}" class="btn btn-sm btn-primary">
                                        View Details
                                    </a>
                                    @if($order->status === 'unpaid')
                                        <form action="/payment" method="POST" style="display:inline;">
                                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                                            <button type="submit" class="btn btn-sm btn-success">Mark as Paid</button>
                                        </form>
                                    @endif
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
