<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ route('admin.home_page') }}" class="site_title">
                {{-- <i class="fa fa-paw"></i> --}}
                <img src="img-logo/VT_luxury.png" alt="Logo" class="w-25">
                <span>VT Luxury</span>
            </a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{ getInfoUser() }}</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <ul class="nav side-menu">
                    <li><a href="{{ route('admin.home_page') }}"><i class="fa fa-home"></i> Home</a>
                    </li>
                    <li><a href="{{ route('companies.index') }}"><i class="fa fa-building"></i> Quản lý công ty</a>
                    </li>
                    <li><a><i class="fa fa-group"></i> Quản lý nhân sự <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('users.index') }}"><i class="fa fa-user"></i> Quản lý user</a></li>
                            <li><a href="{{ route('persons.index') }}"><i class="fa fa-user"></i> Quản lý nhân viên</a></li>
                            <li><a href="{{ route('roles.index') }}"><i class="fa fa-sitemap"></i> Quản lý vai trò</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-building-o"></i> Quản lý phòng ban</a>
                    </li>
                    <li><a><i class="fa fa-briefcase"></i> Quản lý dự án</a>
                    </li>
                    <li><a><i class="fa fa-tasks"></i> Quản lý công việc</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Logout"
                href="{{ route('admin_authentication.logout') }}">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>
