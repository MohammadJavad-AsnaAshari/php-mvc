@component('admin.layouts.content', ['title' => 'Edit Comment'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active"><a href="/admin-panel/comments">Comments</a></li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Comment</h3>
                </div>
                <form action="/admin-panel/comments/update" method="POST">
                    <div class="card-body">
                        <div class="form-group pb-3">
                            <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                            <div class="form-group">
                                <label for="comment" class="col-sm-2 control-label pb-2">Comment</label>
                                <textarea name="comment" id="comment" class="form-control"
                                          rows="3">{{ $comment->comment }}</textarea>
                            </div>
                            @if($errors->has('comment'))
                                <span style="color: red; font-weight: bolder">{{ $errors->first('comment') }}</span>
                            @endif
                        </div>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer d-flex"
                         style="display: flex; justify-content: space-between; flex-wrap: wrap;">
                        <button type="submit" class="btn btn-info">Edit Comment</button>
                        <a href="/admin-panel/comments" type="submit"
                           class="btn btn-default float-left">Cancel</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

@endcomponent
