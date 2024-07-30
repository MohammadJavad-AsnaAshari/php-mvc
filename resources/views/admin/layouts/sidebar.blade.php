<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
    <div class="sidebar-brand"> <!--begin::Brand Link--> <a href="/" class="brand-link"> <!--begin::Brand Image--> <img
                    src="/dist/assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow">
            <!--end::Brand Image--> <!--begin::Brand Text--> <span
                    class="brand-text fw-light">{{ $_ENV['APP_NAME'] }}</span> <!--end::Brand Text--> </a>
        <!--end::Brand Link--> </div> <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2"> <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item {{ isActive('/admin-panel', "menu-open") }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Dashboard
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{ isActive('/admin-panel') }}">
                            <a href="/admin-panel" class="nav-link {{ isUrl('/admin-panel')}}">
                                <i class="nav-icon bi {{ request()->isUrl('/admin-panel') ? 'bi-shield-fill' : 'bi-shield' }}"></i>
                                <p>Admin Panel</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ isActive(['/admin-panel/users', '/admin-panel/users/create'], "menu-open") }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>
                            Users
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{ isActive('/admin-panel/users') }}">
                            <a href="/admin-panel/users" class="nav-link {{ isUrl('/admin-panel/users')}}">
                                <i class="nav-icon bi {{ request()->isUrl('/admin-panel/users') ? 'bi-person-fill' : 'bi-person' }}"></i>
                                <p>Index</p>
                            </a>
                        </li>
                        <li class="nav-item {{ isActive('/admin-panel/create') }}">
                            <a href="/admin-panel/users/create"
                               class="nav-link {{ isUrl('/admin-panel/users/create')}}">
                                <i class="nav-icon bi {{ request()->isUrl('/admin-panel/users/create') ? 'bi-person-fill' : 'bi-person' }}"></i>
                                <p>Create</p>
                            </a>
                        </li>
                        <li class="nav-item {{ isActive('/admin-panel/edit/*') }}">
                            <a href="/admin-panel/users" class="nav-link {{ isUrl('/admin-panel/users')}}">
                                <i class="nav-icon bi {{ request()->isUrl('/admin-panel/users') ? 'bi-person-fill' : 'bi-person' }}"></i>
                                <p>Edit</p>
                            </a>
                        </li>
                        <li class="nav-item {{ isActive('/admin-panel/users') }}">
                            <a href="/admin-panel/users" class="nav-link {{ isUrl('/admin-panel/users')}}">
                                <i class="nav-icon bi {{ request()->isUrl('/admin-panel/users') ? 'bi-person-fill' : 'bi-person' }}"></i>
                                <p>Delete</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ isActive(['/admin-panel/roles', '/admin-panel/roles/create', '/admin-panel/permissions', '/admin-panel/permissions/create'], "menu-open") }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-shield-fill"></i>
                        <p>
                            Access
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{ isActive(['/admin-panel/permissions', '/admin-panel/permissions/create']) }}">
                            <a href="/admin-panel/permissions"
                               class="nav-link {{ isActive(['/admin-panel/permissions', '/admin-panel/permissions/create'])}}">
                                <i class="nav-icon bi bi-universal-access"></i>
                                <p>Permissions</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ isActive(['/admin-panel/products', '/admin-panel/products/create'], "menu-open") }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-ui-checks-grid"></i>
                        <p>
                            Products
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{ isActive('/admin-panel/products') }}">
                            <a href="/admin-panel/products" class="nav-link {{ isUrl('/admin-panel/products')}}">
                                <i class="nav-icon bi {{ request()->isUrl('/admin-panel/products') ? 'bi-patch-check-fill' : 'bi-patch-check' }}"></i>
                                <p>Index</p>
                            </a>
                        </li>
                        <li class="nav-item {{ isActive('/admin-panel/create') }}">
                            <a href="/admin-panel/products/create"
                               class="nav-link {{ isUrl('/admin-panel/products/create')}}">
                                <i class="nav-icon bi {{ request()->isUrl('/admin-panel/products/create') ? 'bi-patch-check-fill' : 'bi-patch-check' }}"></i>
                                <p>Create</p>
                            </a>
                        </li>
                        <li class="nav-item {{ isActive('/admin-panel/edit/*') }}">
                            <a href="/admin-panel/products" class="nav-link {{ isUrl('/admin-panel/products')}}">
                                <i class="nav-icon bi {{ request()->isUrl('/admin-panel/products') ? 'bi-patch-check-fill' : 'bi-patch-check' }}"></i>
                                <p>Edit</p>
                            </a>
                        </li>
                        <li class="nav-item {{ isActive('/admin-panel/products') }}">
                            <a href="/admin-panel/products" class="nav-link {{ isUrl('/admin-panel/products')}}">
                                <i class="nav-icon bi {{ request()->isUrl('/admin-panel/products') ? 'bi-patch-check-fill' : 'bi-patch-check' }}"></i>
                                <p>Delete</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ isActive(['/admin-panel/categories'], "menu-open") }}">
                    <a href="#" class="nav-link"> <i class="nav-icon bi-card-checklist"></i>
                        <p>
                            Categories
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{ isActive('/admin-panel/categories') }}">
                            <a href="/admin-panel/categories"
                               class="nav-link {{ isUrl('/admin-panel/categories')}}">
                                <i class="nav-icon bi bi-card-list"></i>
                                <p>Index</p>
                            </a>
                        </li>
                        <li class="nav-item {{ isActive('/admin-panel/categories/create') }}">
                            <a href="/admin-panel/categories/create"
                               class="nav-link {{ isUrl('/admin-panel/categories/create')}}">
                                <i class="nav-icon bi bi-card-list"></i>
                                <p>Create</p>
                            </a>
                        </li>
                        <li class="nav-item {{ isActive('/admin-panel/categories') }}">
                            <a href="/admin-panel/categories"
                               class="nav-link {{ isUrl('/admin-panel/categories')}}">
                                <i class="nav-icon bi bi-card-list"></i>
                                <p>Edit</p>
                            </a>
                        </li>
                        <li class="nav-item {{ isActive('/admin-panel/categories') }}">
                            <a href="/admin-panel/categories"
                               class="nav-link {{ isUrl('/admin-panel/categories')}}">
                                <i class="nav-icon bi bi-card-list"></i>
                                <p>Delete</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ isActive(['/admin-panel/comments'], "menu-open") }}">
                    <a href="#" class="nav-link"> <i class="nav-icon bi bi-chat-fill"></i>
                        <p>
                            Comments
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{ isActive('/admin-panel/comments') }}">
                            <a href="/admin-panel/comments"
                               class="nav-link {{ isUrl('/admin-panel/comments')}}">
                                <i class="nav-icon bi {{ request()->isUrl('/admin-panel/comments') ? 'bi-chat-fill' : 'bi-chat' }}"></i>
                                <p>Index</p>
                            </a>
                        </li>
                        <li class="nav-item {{ isActive('/admin-panel/comments') }}">
                            <a href="/admin-panel/comments"
                               class="nav-link {{ isUrl('/admin-panel/comments')}}">
                                <i class="nav-icon bi {{ request()->isUrl('/admin-panel/comments') ? 'bi-chat-fill' : 'bi-chat' }}"></i>
                                <p>Edit</p>
                            </a>
                        </li>
                        <li class="nav-item {{ isActive('/admin-panel/comments') }}">
                            <a href="/admin-panel/comments"
                               class="nav-link {{ isUrl('/admin-panel/comments')}}">
                                <i class="nav-icon bi {{ request()->isUrl('/admin-panel/comments') ? 'bi-chat-fill' : 'bi-chat' }}"></i>
                                <p>Delete</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ isActive(['/admin-panel/orders'], "menu-open") }}">
                    <a href="#" class="nav-link"> <i class="nav-icon bi bi-shop"></i>
                        <p>
                            Orders
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{ isActive('/admin-panel/orders') }}">
                            <a href="/admin-panel/orders"
                               class="nav-link {{ isUrl('/admin-panel/orders')}}">
                                <i class="nav-icon bi bi bi-shop"></i>
                                <p>Index</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul> <!--end::Sidebar Menu-->
        </nav>
    </div> <!--end::Sidebar Wrapper-->
</aside> <!--end::Sidebar--> <!--begin::App Main-->