<!-- header section strats -->
<header class="header_section">
    <nav class="navbar navbar-expand-lg custom_nav-container ">
        <a class="navbar-brand" href="/">
          <span>
            <?= $_ENV['APP_NAME'] ?>
          </span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""></span>
        </button>

        <div class="collapse navbar-collapse innerpage_navbar" id="navbarSupportedContent">
            <ul class="navbar-nav  ">
                <li class="nav-item ">
                    <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item {{ isUrl('/shop') ? 'active' : ''}}">
                    <a class="nav-link" href="/shop">
                        Shop
                    </a>
                </li>
                <li class="nav-item {{ isUrl('/popular')}}">
                    <a class="nav-link" href="/popular">
                        Popular
                    </a>
                </li>
                <li class="nav-item {{ isUrl('/categories') }}">
                    <a class="nav-link" href="/categories">
                        Categories
                    </a>
                </li>
                <li class="nav-item {{ isUrl('/about-us')}}">
                    <a class="nav-link" href="/about-us">
                        About Us
                    </a>
                </li>
                <li class="nav-item {{ isUrl('/contact-us')}}">
                    <a class="nav-link" href="/contact-us">Contact Us</a>
                </li>
                <li class="nav-item {{ isUrl('/cart')}}">
                    <a class="nav-link" href="/cart">
                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                    </a>
                </li>
            </ul>

            <div class="user_option">
                @if(auth()->check())
                    @if(auth()->user()->hasPermission('admin'))
                        <a href="/admin-panel">
                            <i class="fa fa-shield" aria-hidden="true"></i>
                            <span>Admin Panel</span>
                        </a>
                    @elseif(auth()->user()->hasPermission('user-index'))
                        <a href="/admin-panel/users">
                            <i class="fa fa-shield" aria-hidden="true"></i>
                            <span>Users Panel</span>
                        </a>
                    @elseif(auth()->user()->hasPermission('permission-index'))
                        <a href="/admin-panel/permissions">
                            <i class="fa fa-shield" aria-hidden="true"></i>
                            <span>Permissions Panel</span>
                        </a>
                    @elseif(auth()->user()->hasPermission('product-index'))
                        <a href="/admin-panel/products">
                            <i class="fa fa-shield" aria-hidden="true"></i>
                            <span>Products Panel</span>
                        </a>
                    @elseif(auth()->user()->hasPermission('category-index'))
                        <a href="/admin-panel/categories">
                            <i class="fa fa-shield" aria-hidden="true"></i>
                            <span>Categories Panel</span>
                        </a>
                    @elseif(auth()->user()->hasPermission('comment-index'))
                        <a href="/admin-panel/comments">
                            <i class="fa fa-shield" aria-hidden="true"></i>
                            <span>Comments Panel</span>
                        </a>
                    @elseif(auth()->user()->hasPermission('order-index'))
                        <a href="/admin-panel/orders">
                            <i class="fa fa-shield" aria-hidden="true"></i>
                            <span>Orders Panel</span>
                        </a>
                    @elseif(auth()->user()->hasPermission('database-backup'))
                        <a href="/admin-panel/database/backup">
                            <i class="fa fa-shield" aria-hidden="true"></i>
                            <span>Database Backup Panel</span>
                        </a>
                    @elseif(auth()->user()->hasPermission('database-recovery'))
                        <a href="/admin-panel/database/recovery">
                            <i class="fa fa-shield" aria-hidden="true"></i>
                            <span>Database Recovery Panel</span>
                        </a>
                    @endif
                    <a href="/user-panel/{{ auth()->user()->id }}">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span>{{ auth()->user()->name }}</span>
                    </a>
                    <a href="/auth/logout">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                        <span>Logout</span>
                    </a>
                @else
                    <a href="/auth/login">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span>
                            Login
                        </span>
                    </a>
                    <a href="/auth/register">
                        <i class="fa fa-user" aria-hidden="true"></i>
                        <span>
                            Register
                        </span>
                    </a>
                @endif
            </div>
        </div>
    </nav>
</header>
<!-- end header section -->