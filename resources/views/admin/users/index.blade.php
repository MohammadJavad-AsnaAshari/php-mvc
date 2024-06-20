@component('admin.layouts.content', ['title' => 'Users'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Users</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Users Index</h3>

                    <div class="card-tools d-flex">
                        <div class="btn-group-sm" style="margin-right: 1rem;">
                            <a href="/admin-panel/users/create" class="btn btn-info">Create New User</a>
                            <a href="" class="btn btn-warning">Admin Users</a>
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
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Permissions</th>
                            <th>Rules</th>
                            <th>Action</th>
                        </tr>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <a href="/user-panel/{{ $user->id }}">
                                        {{ $user->name }}
                                    </a>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
{{--                                @if($user->status === 'active')--}}
{{--                                    <td><span class="badge bg-success">Active</span></td>--}}
{{--                                @else--}}
{{--                                    <td><span class="badge bg-danger">Inactive</span></td>--}}
{{--                                @endif--}}
                                <td>
                                   {{ $user->permissions }}
                                </td>
                                <td>
                                   {{ $user->roles }}
                                </td>
                                <td class="d-flex">
                                    <a href="/admin-panel/users/edit/{{ $user->id }}" class="btn btn-sm btn-primary">
                                        edit
                                    </a>
                                    <form action="/admin-panel/users/delete" class="delete-form" method="POST">
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
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