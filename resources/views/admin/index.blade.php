@component('admin.layouts.content', ['title' => 'Admin Panel'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Admin Panel</li>
    @endslot

@endcomponent