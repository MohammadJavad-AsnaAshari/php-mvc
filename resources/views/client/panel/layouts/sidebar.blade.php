<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
    <div class="sidebar-brand"> <!--begin::Brand Link--> <a href="/" class="brand-link"> <!--begin::Brand Image--> <img
                    src="/dist/assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow">
            <!--end::Brand Image--> <!--begin::Brand Text--> <span
                    class="brand-text fw-light">{{ $_ENV['APP_NAME'] }}</span> <!--end::Brand Text--> </a>
        <!--end::Brand Link--> </div> <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->

    @php
        $userId = auth()->user()->id;
    @endphp

    <div class="sidebar-wrapper">
        <nav class="mt-2"> <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>
                            User
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{ isActive("/user-panel/$userId") }}">
                            <a href="/user-panel/{{ $userId }}" class="nav-link {{ isUrl("/user-panel/$userId")}}">
                                <i class="nav-icon bi {{ request()->isUrl("/user-panel/$userId") ? 'bi-person-fill' : 'bi-person' }}"></i>
                                <p>Index</p>
                            </a>
                        </li>
                        <li class="nav-item {{ isActive("/user-panel/edit/$userId") }}">
                            <a href="/user-panel/edit/{{ $userId }}"
                               class="nav-link {{ isUrl("/user-panel/edit/$userId")}}">
                                <i class="nav-icon bi {{ request()->isUrl("/user-panel/edit/$userId") ? 'bi-person-fill' : 'bi-person' }}"></i>
                                <p>Edit</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul> <!--end::Sidebar Menu-->
        </nav>
    </div> <!--end::Sidebar Wrapper-->
</aside> <!--end::Sidebar--> <!--begin::App Main-->