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

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  ">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/shop">
                        Shop
                    </a>
                </li>
                <li class="nav-item {{ isUrl('/popular') }}">
                    <a class="nav-link" href="/popular">
                        Popular
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/about-us">
                        About Us
                    </a>
                </li>
                <li class="nav-item {{ isUrl('/contact-us')}}">
                    <a class="nav-link" href="/contact-us">Contact Us</a>
                </li>
            </ul>
            <div class="user_option">
                @if(auth()->check())
                    @if(auth()->user()->hasRole('admin'))
                        <a href="/admin-panel">
                            <i class="fa fa-shield" aria-hidden="true"></i>
                            <span>Admin Panel</span>
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
                <a href="">
                    <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </nav>
</header>
<!-- end header section -->