<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark border-bottom-0 text-white" style="background: #837000">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('home') }}" class="nav-link" target="_blank">{{ env('APP_NAME') }} Home</a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <!-- Notifications Dropdown Menu -->
        @permission('read-notifications')
        @include('backend.components.notifications.index')
        @endpermission
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="{{ asset('administration/img/admin_avatar.png') }}" class="user-image img-circle elevation-2" alt="Admin Photo">
                <span class="d-none d-md-inline">{{ \auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right border-top-0">
                <!-- User image -->
                <li class="user-header bg-dark">
                    <img src="{{ asset('administration/img/admin_avatar.png') }}" class="img-circle elevation-2" alt="Admin photo">
                    <p>{{ \auth::user()->name }}
                        <small>{{ Auth::user()->job_title }}</small>
                    </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href="{{ route('admin.profile') }}" class="btn btn-default btn-flat"><i class="fas fa-user-cog"></i>&nbsp; Profile</a>
                    <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat float-right" onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                        <i class="fa fa-power-off"></i>&nbsp; Sign out
                    </a>
                    <i class="fa fa-angle-left"></i>
                    <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
