<div class="sidebar-area" id="sidebar-area">
    <div class="logo position-relative">
        <a href="index.html" class="d-block text-decoration-none">
            <img src="{{asset('img/logo.png')}}" alt="logo-icon">
        </a>
        <button class="sidebar-burger-menu bg-transparent p-0 border-0 opacity-0 z-n1 position-absolute top-50 end-0 translate-middle-y" id="sidebar-burger-menu">
            <i data-feather="x"></i>
        </button>
    </div>
    <aside id="layout-menu" class="layout-menu menu-vertical menu " data-simplebar>
        <ul class="menu-inner">
            <li class="menu-item open">
                <a href="{{route('admin.dashboard')}}" class="menu-link @if(Route::current()->getName() =="admin.dashboard") active @endif">
                    داشبورد
                </a>
            </li>
            <li class="menu-item open">
                <a href="{{route('companies.index')}}" class="menu-link @if(Route::current()->getName() =="companies.index") active @endif">
                    شرکت ها
                </a>
            </li>



        </ul>
    </aside>
    <div class="bg-white z-1 admin">
        <div class="d-flex align-items-center admin-info border-top">
            <div class="flex-shrink-0">
                <a href="{{route('home')}}" class="d-block">
                    <img src="#" class="rounded-circle wh-54" alt="admin">
                </a>
            </div>
            <div class="flex-grow-1 ms-3 info">
                <a href="{{route('home')}}" class="d-block name">MrMDCOde</a>
                <form class="d-none" id="f-logout" action="{{route('logout')}}" method="post">
                    @csrf
                </form>
                <a onclick="$('#f-logout').submit()">خروج</a>
            </div>
        </div>
    </div>
</div>
