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
                            <a href="/admin-panel/users/create" class="nav-link {{ isUrl('/admin-panel/users/create')}}">
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
                <li class="nav-item {{ isActive(['/admin-panel/roles', '/admin-panel/roles/create', '/admin-panel/permissions'], "menu-open") }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-shield-fill"></i>
                        <p>
                            Access
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item {{ isActive('/admin-panel/roles') }}">
                            <a href="/admin-panel/roles" class="nav-link {{ isUrl('/admin-panel/roles') }}">
                                <i class="nav-icon bi bi-check"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        <li class="nav-item {{ isActive('/admin-panel/permissions') }}">
                            <a href="/admin-panel/users" class="nav-link {{ isUrl('/admin-panel/permissions')}}">
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
                            <a href="/admin-panel/products/create" class="nav-link {{ isUrl('/admin-panel/products/create')}}">
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
                <li class="nav-item"><a href="#" class="nav-link"> <i class="nav-icon bi bi-tree-fill"></i>
                        <p>
                            UI Elements
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="./UI/general.html" class="nav-link"> <i
                                        class="nav-icon bi bi-circle"></i>
                                <p>General</p>
                            </a></li>
                        <li class="nav-item"><a href="./UI/timeline.html" class="nav-link"> <i
                                        class="nav-icon bi bi-circle"></i>
                                <p>Timeline</p>
                            </a></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="nav-icon bi bi-pencil-square"></i>
                        <p>
                            Forms
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="./forms/general.html" class="nav-link"> <i
                                        class="nav-icon bi bi-circle"></i>
                                <p>General Elements</p>
                            </a></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="nav-icon bi bi-table"></i>
                        <p>
                            Tables
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="./tables/simple.html" class="nav-link"> <i
                                        class="nav-icon bi bi-circle"></i>
                                <p>Simple Tables</p>
                            </a></li>
                    </ul>
                </li>
                <li class="nav-header">EXAMPLES</li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="nav-icon bi bi-box-arrow-in-right"></i>
                        <p>
                            Auth
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="#" class="nav-link"> <i
                                        class="nav-icon bi bi-box-arrow-in-right"></i>
                                <p>
                                    Version 1
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"><a href="./examples/login.html" class="nav-link"> <i
                                                class="nav-icon bi bi-circle"></i>
                                        <p>Login</p>
                                    </a></li>
                                <li class="nav-item"><a href="./examples/register.html" class="nav-link"> <i
                                                class="nav-icon bi bi-circle"></i>
                                        <p>Register</p>
                                    </a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a href="#" class="nav-link"> <i
                                        class="nav-icon bi bi-box-arrow-in-right"></i>
                                <p>
                                    Version 2
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"><a href="./examples/login-v2.html" class="nav-link"> <i
                                                class="nav-icon bi bi-circle"></i>
                                        <p>Login</p>
                                    </a></li>
                                <li class="nav-item"><a href="./examples/register-v2.html" class="nav-link"> <i
                                                class="nav-icon bi bi-circle"></i>
                                        <p>Register</p>
                                    </a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a href="./examples/lockscreen.html" class="nav-link"> <i
                                        class="nav-icon bi bi-circle"></i>
                                <p>Lockscreen</p>
                            </a></li>
                    </ul>
                </li>
                <li class="nav-header">DOCUMENTATIONS</li>
                <li class="nav-item"><a href="./docs/introduction.html" class="nav-link"> <i
                                class="nav-icon bi bi-download"></i>
                        <p>Installation</p>
                    </a></li>
                <li class="nav-item"><a href="./docs/layout.html" class="nav-link"> <i
                                class="nav-icon bi bi-grip-horizontal"></i>
                        <p>Layout</p>
                    </a></li>
                <li class="nav-item"><a href="./docs/color-mode.html" class="nav-link"> <i
                                class="nav-icon bi bi-star-half"></i>
                        <p>Color Mode</p>
                    </a></li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="nav-icon bi bi-ui-checks-grid"></i>
                        <p>
                            Components
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="./docs/components/main-header.html" class="nav-link"> <i
                                        class="nav-icon bi bi-circle"></i>
                                <p>Main Header</p>
                            </a></li>
                        <li class="nav-item"><a href="./docs/components/main-sidebar.html" class="nav-link"> <i
                                        class="nav-icon bi bi-circle"></i>
                                <p>Main Sidebar</p>
                            </a></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="nav-icon bi bi-filetype-js"></i>
                        <p>
                            Javascript
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="./docs/javascript/treeview.html" class="nav-link"> <i
                                        class="nav-icon bi bi-circle"></i>
                                <p>Treeview</p>
                            </a></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="./docs/browser-support.html" class="nav-link"> <i
                                class="nav-icon bi bi-browser-edge"></i>
                        <p>Browser Support</p>
                    </a></li>
                <li class="nav-item"><a href="./docs/how-to-contribute.html" class="nav-link"> <i
                                class="nav-icon bi bi-hand-thumbs-up-fill"></i>
                        <p>How To Contribute</p>
                    </a></li>
                <li class="nav-item"><a href="./docs/faq.html" class="nav-link"> <i
                                class="nav-icon bi bi-question-circle-fill"></i>
                        <p>FAQ</p>
                    </a></li>
                <li class="nav-item"><a href="./docs/license.html" class="nav-link"> <i
                                class="nav-icon bi bi-patch-check-fill"></i>
                        <p>License</p>
                    </a></li>
                <li class="nav-header">MULTI LEVEL EXAMPLE</li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="nav-icon bi bi-circle-fill"></i>
                        <p>Level 1</p>
                    </a></li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="nav-icon bi bi-circle-fill"></i>
                        <p>
                            Level 1
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"><a href="#" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Level 2</p>
                            </a></li>
                        <li class="nav-item"><a href="#" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>
                                    Level 2
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"><a href="#" class="nav-link"> <i
                                                class="nav-icon bi bi-record-circle-fill"></i>
                                        <p>Level 3</p>
                                    </a></li>
                                <li class="nav-item"><a href="#" class="nav-link"> <i
                                                class="nav-icon bi bi-record-circle-fill"></i>
                                        <p>Level 3</p>
                                    </a></li>
                                <li class="nav-item"><a href="#" class="nav-link"> <i
                                                class="nav-icon bi bi-record-circle-fill"></i>
                                        <p>Level 3</p>
                                    </a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a href="#" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Level 2</p>
                            </a></li>
                    </ul>
                </li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="nav-icon bi bi-circle-fill"></i>
                        <p>Level 1</p>
                    </a></li>
                <li class="nav-header">LABELS</li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="nav-icon bi bi-circle text-danger"></i>
                        <p class="text">Important</p>
                    </a></li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="nav-icon bi bi-circle text-warning"></i>
                        <p>Warning</p>
                    </a></li>
                <li class="nav-item"><a href="#" class="nav-link"> <i class="nav-icon bi bi-circle text-info"></i>
                        <p>Informational</p>
                    </a></li>
            </ul> <!--end::Sidebar Menu-->
        </nav>
    </div> <!--end::Sidebar Wrapper-->
</aside> <!--end::Sidebar--> <!--begin::App Main-->