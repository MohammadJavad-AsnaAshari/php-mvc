@component('admin.layouts.content', ['title' => 'Categories'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Categories</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Categories Index</h3>

                    <div class="card-tools d-flex">
                        <div class="btn-group-sm" style="margin-right: 1rem;">
                            <a href="/admin-panel/categories/create" class="btn btn-info">Create New Category</a>
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
                            <th>Category Name</th>
                            <th>Parent Name</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->parent_name }}</td>
                                <td>{{ $category->created_at }}</td>
                                <td class="d-flex">
                                    <a href="/admin-panel/categories/edit/{{ $category->id }}"
                                       class="btn btn-sm btn-primary">
                                        edit
                                    </a>
                                    <form action="/admin-panel/categories/delete" class="delete-form" method="POST">
                                        <input type="hidden" name="category_id" value="{{ $category->id }}">
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