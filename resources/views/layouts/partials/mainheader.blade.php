<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/dashboard') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">MH</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{{-- <img src="" style="height: 35px; width:36px;"> --}}<b> My Hall</b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ trans('adminlte_lang::message.togglenav') }}</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">               
                @if (Auth::guest())
                    <li><a href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>
                    <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                @else
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            @if(Auth::user()->userinfos()->first() == null || Auth::user()->userinfos()->first()->photo == null)
                            <img src="{{asset('/images/profile.jpg')}}" class="user-image" alt="User Image"/>
                            @else
                            <img src="{{url('images/users/'.Auth::user()->userinfos()->first()->photo)}}" class="user-image" alt="User Image"/>
                            @endif
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                @if(Auth::user()->userinfos()->first() == null || Auth::user()->userinfos()->first()->photo == null)
                                <img src="{{asset('/images/profile.jpg')}}" class="img-circle" alt="User Image" />
                                @else
                                <img src="{{url('images/users/'.Auth::user()->userinfos()->first()->photo)}}" class="img-circle" alt="User Image" />
                                @endif
                                <p>
                                    {{ Auth::user()->name }}
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{route('change.password')}}" class="btn btn-default btn-flat">Change Password</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">{{ trans('adminlte_lang::message.signout') }}</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>
