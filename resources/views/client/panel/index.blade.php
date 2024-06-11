@component('client.panel.layouts.content', ['title' => $user->name ])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">User</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $user->name }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>Id</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <a href="/user-panel/{{ $user->id }}">
                                    {{ $user->name }}
                                </a>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td class="d-flex">
                                <a href="/user-panel/edit/{{ $user->id }}" class="btn btn-sm btn-primary">
                                    edit
                                </a>
                                <form action="/user-panel/delete" class="delete-form" method="POST">
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <button class="btn btn-sm btn-danger" style="margin-left: 10px;">
                                        delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

@endcomponent