<div class="sidebar">
    <div class="sidebar-header">
        @if(Auth::user()->role == 'gudang')
            <i class="fas fa-warehouse me-2"></i>
            Gudang
        @else
            <i class="fas fa-kitchen-set me-2"></i>
            Client
        @endif
    </div>
    <ul class="nav flex-column">

        {{-- MENU Admin --}}
        @if(Auth::check() && Auth::user()->role == 'gudang')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('gudang.dashboard') ? 'active' : '' }}" href="{{ route('gudang.dashboard') }}">
                    <i class="fas fa-tachometer-alt fa-fw me-2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('gudang.bahan_baku.index') ? 'active' : '' }}" href="{{ route('gudang.bahan_baku.index') }}">
                    <i class="fas fa-bell-concierge fa-fw me-2"></i> Kelola Bahan Baku
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('gudang.kelola_request.index') ? 'active' : '' }}" href="{{ route('gudang.kelola_request.index') }}">
                    <i class="fas fa-exclamation fa-fw me-2"></i> Kelola Permintaan
                </a>
            </li>

        @endif

        {{-- MENU Client --}}
        @if(Auth::check() && Auth::user()->role == 'dapur')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dapur.dashboard') ? 'active' : '' }}" href="{{ route('dapur.dashboard') }}">
                    <i class="fas fa-user fa-fw me-2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dapur.request_bahan_baku.index') ? 'active' : '' }}" href="{{ route('dapur.request_bahan_baku.index') }}">
                    <i class="fas fa-bell-concierge fa-fw me-2"></i> Request
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
