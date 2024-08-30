<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color:#c4cdd3">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <!-- Display User's Name and Logout -->
        @if (Auth::check())
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-user"></i> {{ Auth::user()->name }}
                </a>
            </li>
            <!-- Logout Link -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.logout') }}">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        @endif
    </ul>
</nav>
