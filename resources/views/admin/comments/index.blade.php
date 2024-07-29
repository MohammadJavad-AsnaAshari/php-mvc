@component('admin.layouts.content', ['title' => 'Comments'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Comments</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Comments Index</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>Id</th>
                            <th>User Name</th>
                            <th>Product</th>
                            <th>Comment</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        @foreach($comments as $comment)
                            <tr>
                                <td>{{ $comment->id }}</td>
                                <td>
                                    <a href="/user-panel/{{ $comment->user_id }}">
                                        {{ $comment->user_name }}
                                    </a>
                                </td>
                                <td>
                                    <a href="/shop/{{ $comment->product_id }}">
                                        {{ $comment->product_name }}
                                    </a>
                                </td>
                                <td>{{ $comment->comment }}</td>
                                <td>{{ $comment->status }}</td>
                                <td>{{ $comment->created_at }}</td>
                                <td class="d-flex">
                                    <a href="/admin-panel/comments/edit/{{ $comment->id }}" class="btn btn-sm btn-primary">
                                        edit
                                    </a>
                                    <form action="/admin-panel/comments/delete" class="delete-form" method="POST">
                                        <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                                        <button class="btn btn-sm btn-danger" style="margin-left: 10px;">
                                            delete
                                        </button>
                                    </form>
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
