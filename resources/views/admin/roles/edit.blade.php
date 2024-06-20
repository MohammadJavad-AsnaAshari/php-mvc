@component('admin.layouts.content', ['title' => 'Edit Role'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Roles</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Role</h3>
                </div>
                <!-- /.card-header -->
                <form action="/admin-panel/roles/update" method="POST">
                    <div class="card-body">
                        <div class="form-group pb-3">
                            <label for="name" class="col-sm-2 control-label">Roles Name</label>
                            <input type="text" name="name" class="form-control" id="name"
                                   placeholder="Enter role's name" autocomplete="name" value="{{ $role->name }}"
                                   required>
                            @if($errors->has('name'))
                                <span style="color: red; font-weight: bolder">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group pb-3">
                            <label for="label" class="col-sm-2 control-label">Roles Label</label>
                            <input type="text" name="label" class="form-control" id="label"
                                   placeholder="Enter role's label" autocomplete="name" value="{{ $role->label }}"
                                   required>
                            @if($errors->has('label'))
                                <span style="color: red; font-weight: bolder">{{ $errors->first('label') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Permissions</label>
                            <select name="permissions[]" id="permissions" class="form-select" multiple>
                                @foreach($permissions as $permission)
                                    <option value="{{$permission->id}}" {{ in_array($permission->id, $rolePermissionIds) ? 'selected' : '' }}>
                                        {{$permission->name}} - {{$permission->label}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer d-flex"
                         style="display: flex; justify-content: space-between; flex-wrap: wrap;">
                        <input type="hidden" name="role_id" value="{{ $role->id }}">
                        <button type="submit" class="btn btn-info">Update Role</button>
                        <a href="/admin-panel/roles" type="submit"
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