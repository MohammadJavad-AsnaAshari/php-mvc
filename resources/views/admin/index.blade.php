@component('admin.layouts.content', ['title' => 'پنل مدیریت'])

    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="#">خانه</a></li>
        <li class="breadcrumb-item active">پنل مدیریت</li>
    @endslot

    <h1>Admin</h1>
@endcomponent