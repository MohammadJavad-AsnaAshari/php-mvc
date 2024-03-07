@component('admin.layouts.content', ['title' => 'لیست کاربران'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="#">خانه</a></li>
        <li class="breadcrumb-item active">لیست کاربران</li>
    @endslot

    <h1>Users</h1>
@endcomponent