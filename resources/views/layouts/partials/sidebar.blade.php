<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <div class="row">
        </div>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">@if(Auth::user()->hasAnyRole('admin') == true) Admin @else User @endif's Adminstration</li>
            <li><a href="{{ url('profile') }}"><i class='fa fa-user'></i> <span>Profile</span></a></li>
            <li><a href="{{ url('/students') }}"><i class='fa fa-graduation-cap'></i> <span>Students List</span></a></li>
            <li><a href="{{ url('/staffs') }}"><i class='fa fa-child'></i> <span>Hall Staffs List</span></a></li>
            <li><a href="{{ url('/hall_manager') }}"><i class='fa fa-cutlery'></i> <span>Hall Manager</span></a></li>
            @if(Auth::user()->hasAnyRole(['admin' , 'employee']) == true)
            <li><a href="{{ url('/hallsummary') }}"><i class='fa fa-bed'></i> <span>Hall Summary</span></a></li>
            <li><a href="{{ url('/register') }}"><i class='fa fa-user-plus'></i> <span>Register User</span></a></li>
            {{-- <li><a href="{{ url('/delete_student') }}"><i class='fa fa-user-times'></i> <span>Delete Students</span></a></li> --}}
            @endif
            @if(Auth::user()->hasAnyRole('admin') == true)
            <li class="treeview">
                <a href="#"><i class='fa fa-cog'></i> <span>Settings</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{route('settings.acl')}}">Access Control</a></li>
                    <li><a href="{{route('changeuser.password')}}">Change User Password</a></li>
                </ul>
            </li>
            @endif
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
