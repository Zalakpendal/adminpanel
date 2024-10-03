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
        @if (Auth::check())
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.editprofile') }}">
                    @if (Auth::user()->image)
                        <img src="{{ asset(Auth::user()->image) }}" alt="{{ Auth::user()->name }}" class="user-image">
                    @else
                        <i class="fas fa-user"></i> 
                    @endif
                    {{ Auth::user()->name }}
                </a>
            </li>
            <!-- Logout Link -->
            <li class="nav-item">
                <a class="nav-link logout-button" href="#" onclick="confirmLogout(event)">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        @endif
    </ul>
</nav>

<style>
    .user-image {
        width: 30px; 
        height: 30px; 
        border-radius: 50%; 
        object-fit: cover; 
        margin-right: 5px; 
    }
    .logout-button {
        background-color: gray; 
        color: white; 
        border-radius: 5px;
        padding: 8px 12px; 
        
    }
    .logout-button:hover {
        background-color: gray; 
        
    }
    .logout-button i {
        margin-right: 5px;
    }
</style>
