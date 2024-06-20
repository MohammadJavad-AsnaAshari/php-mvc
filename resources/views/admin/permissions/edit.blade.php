@component('admin.layouts.content', ['title' => 'Edit Permission'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Permissions</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Permission</h3>
                </div>
                <!-- /.card-header -->
                <form action="/admin-panel/permissions/update" method="POST">
                    <div class="card-body">
                        <div class="form-group pb-3">
                            <label for="name" class="col-sm-2 control-label">Permissions Name</label>
                            <input type="text" name="name" class="form-control" id="name"
                                   placeholder="Enter role's name" autocomplete="name" value="{{ $permission->name }}"
                                   required>
                            @if($errors->has('name'))
                                <span style="color: red; font-weight: bolder">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group pb-3">
                            <label for="label" class="col-sm-2 control-label">Permissions Label</label>
                            <input type="text" name="label" class="form-control" id="label"
                                   placeholder="Enter role's label" autocomplete="name" value="{{ $permission->label }}"
                                   required>
                            @if($errors->has('label'))
                                <span style="color: red; font-weight: bolder">{{ $errors->first('label') }}</span>
                            @endif
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer d-flex"
                         style="display: flex; justify-content: space-between; flex-wrap: wrap;">
                        <input type="hidden" name="permission_id" value="{{ $permission->id }}">
                        <button type="submit" class="btn btn-info">Update Permission</button>
                        <a href="/admin-panel/permissions" type="submit"
                           class="btn btn-default float-left">Cancel</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

@endcomponent