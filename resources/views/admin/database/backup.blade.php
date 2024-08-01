@component('admin.layouts.content', ['title' => 'Database Backup'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Database Backup</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Database Backup</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form id="backup-form" action="/admin-panel/database/backup" method="POST">
                        <input type="hidden" id="backup-path" name="backup_path" value="">
                        <button type="submit" class="btn btn-primary mt-3" id="create-backup">Create Backup</button>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endcomponent
