@component('admin.layouts.content', ['title' => 'Contact'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Contact</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Contact Index</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>Id</th>
                            <th>User Name</th>
                            <th>Comment</th>
                            <th>Date</th>
                        </tr>
                        @foreach($contacts as $contact)
                            <tr>
                                <td>{{ $contact['id'] }}</td>
                                <td>
                                    <a href="/user-panel/{{ $contact['user_id'] }}">
                                        {{ $contact['user_name'] }}
                                    </a>
                                </td>
                                <td>{{ $contact['comment'] }}</td>
                                <td>{{ $contact['created_at'] }}</td>
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
