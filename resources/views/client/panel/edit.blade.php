@component('client.panel.layouts.content', ['title' => 'Edit User'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">User</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit User</h3>
                </div>
                <!-- /.card-header -->
                <form action="/user-panel/update" method="POST">
                    <div class="card-body">
                        <div class="form-group pb-3">
                            <label for="inputEmail3" class="col-sm-2 control-label">User Name</label>
                            <input type="text" name="name" class="form-control" id="inputEmail3"
                                   placeholder="Enter user's name" autocomplete="name" value="{{ $user->name }}"
                                   required>
                            @if($errors->has('name'))
                                <span style="color: red; font-weight: bolder">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group pb-3">
                            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                            <input type="email" name="email" class="form-control" id="inputEmail3"
                                   placeholder="Enter user's email" autocomplete="email" value="{{ $user->email }}"
                                   required>
                            @if($errors->has('email'))
                                <span style="color: red; font-weight: bolder">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group pb-3">
                            <label for="password" class="col-sm-2 control-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password"
                                   autocomplete="current-password" value="{{ $old('password') }}"
                                   placeholder="Enter user's password">
                            @if($errors->has('password'))
                                <span style="color: red; font-weight: bolder">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group pb-3">
                            <label for="confirm_password" class="col-sm-2 control-label">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control"
                                   id="confirm_password"
                                   placeholder="Enter user's password">
                            @if($errors->has('confirm_password'))
                                <span style="color: red; font-weight: bolder">{{ $errors->first('confirm_password') }}</span>
                            @endif
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer d-flex"
                         style="display: flex; justify-content: space-between; flex-wrap: wrap;">
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <button type="submit" class="btn btn-info">Update User</button>
                        <a href="/user-panel/{{ $user->id }}" type="submit"
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