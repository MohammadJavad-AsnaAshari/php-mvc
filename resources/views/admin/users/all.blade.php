@component('admin.layouts.content', ['title' => 'All Users'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">All Users</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Table</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right"
                                   placeholder="Search here...">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
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
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                @if($user->status === 'active')
                                    <td><span class="badge bg-success">Active</span></td>
                                @else
                                    <td><span class="badge bg-danger">Inactive</span></td>
                                @endif
                                <td>
                                    <a href="" class="btn btn-sm btn-danger">delete</a>
                                    <a href="" class="btn btn-sm btn-primary">edit</a>
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