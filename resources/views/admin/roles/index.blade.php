@component('admin.layouts.content', ['title' => 'Roles'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Roles</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Roles Index</h3>

                    <div class="card-tools d-flex">
                        <div class="btn-group-sm" style="margin-right: 1rem;">
                            <a href="/admin-panel/roles/create" class="btn btn-info">Create New Role</a>
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
                            <th>Role Name</th>
                            <th>Label</th>
                            <th>Date</th>
                            <th>Access</th>
                            <th>Action</th>
                        </tr>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->label }}</td>
                                <td>{{ $role->created_at }}</td>
                                <td>{{ $role->permissions }}</td>
                                <td class="d-flex">
                                    <a href="/admin-panel/roles/edit/{{ $role->id }}" class="btn btn-sm btn-primary">
                                        edit
                                    </a>
                                    <form action="/admin-panel/roles/delete" class="delete-form" method="POST">
                                        <input type="hidden" name="role_id" value="{{ $role->id }}">
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