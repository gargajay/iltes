<nav id="sidebar">
    <div class="sidebar-header">
        <img src="{{publicPath()}}/assets/images/logo.png" alt="logo" class="img-responsive center-block" style="margin: 0 auto;
        ">
    </div>

    <ul id="metismenu" class="list-unstyled components">
        <li class="{{request()->is('dashboard') ? 'active':""}} ">
            <a href="{{url('/dashboard')}}"><i class="fas fa-house"></i>Dashboard
                 <div class="top"></div><div class="bottom"></div>
            </a>
        </li>
       
        {{-- @can("role-list")
        <li class="{{ request()->is('backend/role*') ? 'active':""}}">
            <a href="{{url('backend/role')}}"><i class="fas fa-list"></i>Roles
                <div class="top"></div><div class="bottom"></div>
            </a>
        </li>
        @endcan
        @can("role-list")
        <li class="{{ request()->is('backend/permission*') ? 'active':""}}">
            <a href="{{url('backend/permission')}}"><i class="fas fa-list"></i>permissions
                <div class="top"></div><div class="bottom"></div>
            </a>
        </li>
        @endcan --}}
       
        @can("inquiry-list")
        <li class="{{request()->is('backend/inquiry*') ? 'active':""}}">
            <a href="{{url('backend/inquiry')}}"><i class="fas fa-user"></i>Inquirys
                <div class="top"></div><div class="bottom"></div>
            </a>
        </li>
        @endcan
        @can("user-list")
        <li class="{{request()->is('backend/user*') ? 'active':""}}">
            <a href="{{url('backend/user')}}"><i class="fas fa-user"></i>Students
                <div class="top"></div><div class="bottom"></div>
            </a>
        </li>
        @endcan
        @can("record-list")
        <li class="{{request()->is('backend/record*') ? 'active':""}}">
            <a href="{{url('backend/record')}}"><i class="fas fa-user"></i>Records
                <div class="top"></div><div class="bottom"></div>
            </a>
        </li>
        @endcan
        {{-- @can("lab-list")
        <li {{request()->routeIs('backend/lab*') ? 'active':""}}>
            <a href="{{url('backend/lab')}}"><i class="fas fa-user"></i>Labs
                <div class="top"></div><div class="bottom"></div>
            </a>
        </li>
        @endcan

        @can("testCategory-list")
        <li {{request()->routeIs('backend/testCategory*') ? 'active':""}}>
            <a href="{{url('backend/testCategory')}}"><i class="fas fa-user"></i>Test Category
                <div class="top"></div><div class="bottom"></div>
            </a>
        </li>
        @endcan --}}
     
    </ul>
</nav>