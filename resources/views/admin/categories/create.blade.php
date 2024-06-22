@component('admin.layouts.content', ['title' => 'Create New Categories'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Categories</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create New Categories</h3>
                </div>
                <!-- /.card-header -->
                <form action="/admin-panel/categories/store" method="POST">
                    <div class="card-body">
                        <div class="form-group pb-3">
                            <label for="parent_id" class="col-sm-2 control-label">Categories</label>
                            <select name="parent_ids[]" id="parent_id" class="form-select" multiple>
                                @foreach($categoris as $category)
                                    <option value="{{$category->id}}">
                                        {{$category->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group pb-3">
                            <label for="name" class="col-sm-2 control-label">Categories Name</label>
                            <input type="text" name="name" class="form-control" id="name"
                                   placeholder="Enter category's name" autocomplete="name" value="{{ $old('name') }}"
                                   required>
                            @if($errors->has('name'))
                                <span style="color: red; font-weight: bolder">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer d-flex"
                         style="display: flex; justify-content: space-between; flex-wrap: wrap;">
                        <button type="submit" class="btn btn-info">Create Category</button>
                        <a href="/admin-panel/users" type="submit"
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