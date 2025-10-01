<div class="sidebar">
    <div class="sidebar-header">

        @if(Auth::user()->role == 'gudang')
            <i class="fas fa-university me-2"></i>
            Admin
        @else
            <i class="fas fa-user me-2"></i>
            Client
        @endif
    </div>
    <ul class="nav flex-column">

        {{-- =================== MENU Admin =================== --}}
        @if(Auth::check() && Auth::user()->role == 'gudang')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('gudang.dashboard') ? 'active' : '' }}" href="{{ route('gudang.dashboard') }}">
                    <i class="fas fa-tachometer-alt fa-fw me-2"></i> Dashboard
                </a>
            </li>


        @endif

        {{-- =================== MENU Client =================== --}}
        @if(Auth::check() && Auth::user()->role == 'dapur')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dapur.dashboard') ? 'active' : '' }}" href="{{ route('dapur.dashboard') }}">
                    <i class="fas fa-user fa-fw me-2"></i> Request Bahan Baku
                </a>
            </li>
        @endif

        {{-- Menu Logout --}}
        <li class="nav-item mt-auto">
             <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt fa-fw me-2"></i> Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</div>
