<div class="navbar-default sidebar">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle"><span class="sr-only">Toggle navigation</span> <span
                class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></button>
    </div>
    <div class="clearfix"></div>
    <div class="sidebar-nav navbar-collapse">

        <!-- user profile pic -->
        <div class="userprofile text-center">
            <div class="userpic">
                <img src="{{ url('templateadmin1/images/admin.png') }}" alt="" class="userpicimg">
                <a href="{{ route('web.admin.dashboard.index') }}"
                   class="btn btn-primary settingbtn">
                    <i class="fa fa-home"></i>
                </a>
            </div>

            <h3 class="username">{{ auth()->guard('web')->user()->name }}</h3>

            <p>{{ auth()->guard('web')->user()->level }}</p>
        </div>
        <div class="clearfix"></div>
        <!-- user profile pic -->

        <ul class="nav" id="side-menu">
            <li>
                <a href="{{ route('web.admin.dashboard.index') }}"
                   class="{{ request()->routeIs('web.admin.dashboard.*') ? 'active' : '' }}">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('web.admin.application.index') }}"
                   class="{{ request()->routeIs('web.admin.application.*') ? 'active' : '' }}">
                    <i class="fa fa-group fa-hospital-o"></i> Application
                </a>
            </li>

            <li>
                <a href="{{ route('web.admin.organization.index') }}"
                   class="{{ request()->routeIs('web.admin.organization.*') ? 'active' : '' }}">
                    <i class="fa fa-group fa-hospital-o"></i> Organization
                </a>
            </li>

            <li>
                <a href="{{ route('web.admin.shift.index') }}"
                   class="{{ request()->routeIs('web.admin.shift.*') ? 'active' : '' }}">
                    <i class="fa fa-group fa-hospital-o"></i> Shift
                </a>
            </li>

            <li>
                <a href="{{ route('web.admin.user.index') }}"
                   class="{{ request()->routeIs('web.admin.user.*') ? 'active' : '' }}">
                    <i class="fa fa-group fa-hospital-o"></i> User
                </a>
            </li>

            <li>
                <a href="{{ route('web.admin.userShift.index') }}"
                   class="{{ request()->routeIs('web.admin.userShift.*') ? 'active' : '' }}">
                    <i class="fa fa-group fa-hospital-o"></i> User Shift
                </a>
            </li>

            <li>
                <a href="{{ route('web.admin.title.index') }}"
                   class="{{ request()->routeIs('web.admin.title.*') ? 'active' : '' }}">
                    <i class="fa fa-group fa-hospital-o"></i> Title
                </a>
            </li>

            <li>
                <a href="{{ route('web.admin.employee.index') }}"
                   class="{{ request()->routeIs('web.admin.employee.*') ? 'active' : '' }}">
                    <i class="fa fa-group fa-hospital-o"></i> Employee
                </a>
            </li>

            <li>
                <a href="{{ route('web.admin.employeeOffDay.index') }}"
                   class="{{ request()->routeIs('web.admin.employeeOffDay.*') ? 'active' : '' }}">
                    <i class="fa fa-group fa-hospital-o"></i> Employee Off Day
                </a>
            </li>

            <li>
                <a href="{{ route('web.admin.motivational.index') }}"
                   class="{{ request()->routeIs('web.admin.motivational.*') ? 'active' : '' }}">
                    <i class="fa fa-group fa-hospital-o"></i> Motivational
                </a>
            </li>

            <li>
                <a href="{{ route('web.admin.attendance.index') }}"
                   class="{{ request()->routeIs('web.admin.attendance.*') ? 'active' : '' }}">
                    <i class="fa fa-group fa-hospital-o"></i> Attendance
                </a>
            </li>

            {{-- Sisanya pointing ke employee.index, bisa kamu ubah sesuai route yang benar --}}
            <li>
                <a href="{{ route('web.admin.breakTime.index') }}"
                   class="{{ request()->routeIs('web.admin.breakTime.*') ? 'active' : '' }}">
                    <i class="fa fa-group fa-hospital-o"></i> Break Time
                </a>
            </li>

            <li>
                <a href="{{ route('web.admin.overTime.index') }}"
                   class="{{ request()->routeIs('web.admin.overTime.*') ? 'active' : '' }}">
                    <i class="fa fa-group fa-hospital-o"></i> Over Time
                </a>
            </li>


            <li>
                <a href="{{ route('web.admin.tripType.index') }}"
                   class="{{ request()->routeIs('web.admin.tripType.*') ? 'active' : '' }}">
                    <i class="fa fa-group fa-hospital-o"></i> Trip Type
                </a>
            </li>

            <li>
                <a href="{{ route('web.admin.trip.index') }}"
                   class="{{ request()->routeIs('web.admin.trip.*') ? 'active' : '' }}">
                    <i class="fa fa-group fa-hospital-o"></i> Trip
                </a>
            </li>


            <li>
                <a href="{{ route('web.admin.visitType.index') }}"
                   class="{{ request()->routeIs('web.admin.visitType.*') ? 'active' : '' }}">
                    <i class="fa fa-group fa-hospital-o"></i> Visit Type
                </a>
            </li>

            <li>
                <a href="{{ route('web.admin.visit.index') }}"
                   class="{{ request()->routeIs('web.admin.visit.*') ? 'active' : '' }}">
                    <i class="fa fa-group fa-hospital-o"></i> Visit
                </a>
            </li>

            <li>
                <a href="{{ route('web.admin.offType.index') }}"
                   class="{{ request()->routeIs('web.admin.offType.*') ? 'active' : '' }}">
                    <i class="fa fa-group fa-hospital-o"></i> Off Type
                </a>
            </li>

            <li>
                <a href="{{ route('web.admin.offDay.index') }}"
                   class="{{ request()->routeIs('web.admin.offDay.*') ? 'active' : '' }}">
                    <i class="fa fa-group fa-hospital-o"></i> Off Day
                </a>
            </li>

            <li>
                <a href="{{ route('web.admin.recape.index') }}"
                   class="{{ request()->routeIs('web.admin.recape.*') ? 'active' : '' }}">
                    <i class="fa fa-group fa-hospital-o"></i> Recape
                </a>
            </li>

            <li>
                <a href="{{ route('web.admin.paySlip.index') }}"
                   class="{{ request()->routeIs('web.admin.paySlip.*') ? 'active' : '' }}">
                    <i class="fa fa-group fa-hospital-o"></i> Pay Slip
                </a>
            </li>


            <li>
                <a href="{{ route('web.admin.logout') }}"
                   onclick="return confirm('Are u sure?');">
                    <i class="fa fa-sign-out"></i> Logout
                </a>
            </li>
        </ul>

    </div>
    <!-- /.sidebar-collapse -->
</div>
