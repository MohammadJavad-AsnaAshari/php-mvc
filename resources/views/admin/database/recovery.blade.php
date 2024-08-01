@component('admin.layouts.content', ['title' => 'Database Recovery'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Database Recovery</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Database Recovery</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form id="recovery-form" action="/admin-panel/database/recovery" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="backup_file">Upload Backup File</label>
                            <input type="file" class="form-control" id="backup_file" name="backup_file" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Restore Database</button>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endcomponent
