<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li>
                <a href="javascript:void(0)" data-toggle="sidebar" class="nav-link nav-link-lg">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>
    </form>
    <?php
        $branchUser = Auth::user()->employee->branch_id;
        $alert = DB::select("select * FROM stocks INNER JOIN items ON stocks.item_id = items.id where stock < min_stock and branch_id = $branchUser");
        $blink = count($alert) > 0;
    ?>
    <ul class="navbar-nav navbar-right">
        <li class="dropdown dropdown-list-toggle">
            @if ($blink)
            <a href="javascript:void(0)" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep">
                <i class="far fa-bell"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">
                    {{ __('Notifikasi') }}
                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    @foreach ( $alert as $alert )
                    <a href="javascript:void(0)" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-icon bg-info text-white">
                            <i class="fas fa-info"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            {{ $alert->name }}
                            <div class="time text-primary">stock = {{ $alert->stock }}</div>
                        </div>
                    </a>
                    @endforeach
                </div>
                <div class="dropdown-footer text-center">
                    {{ __('Footer') }}
                </div>
            </div>
            @else
            <a href="javascript:void(0)" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg">
                <i class="far fa-bell"></i>
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">
                    {{ __('Notifikasi') }}
                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-icon bg-info text-white">
                            <i class="fas fa-info"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            {{ __('Kosong') }}
                            <div class="time text-primary">{{ __('Kosong') }}</div>
                        </div>
                    </a>
                </div>
                <div class="dropdown-footer text-center">
                    {{ __('Footer') }}
                </div>
            </div>
            @endif

            {{-- <div class="dropdown-menu dropdown-list dropdown-menu-right">
                <div class="dropdown-header">
                    {{ __('Notifikasi') }}
                </div>
                <div class="dropdown-list-content dropdown-list-icons">
                    <a href="#" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-icon bg-info text-white">
                            <i class="fas fa-info"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            {{ __('Kyaaaa') }}
                            <div class="time text-primary">{{ __('sadsadsadas') }}</div>
                        </div>
                    </a>
                </div>
                <div class="dropdown-footer text-center">
                    {{ __('Footer') }}
                </div>
            </div> --}}

        </li>
        <li class="dropdown">
            <a href="javascript:void(0)" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ Auth::user()->employee->getAvatar() }}" class="rounded-circle mr-1"
                    style="height: 40px; width:40px">
                <div class="d-sm-none d-lg-inline-block">{{ __('Hai, ') . Auth::user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('showUser') }}" class="dropdown-item has-icon">
                    <i class="fas fa-user-tie"></i> {{ __('User Profil') }}
                </a>
                {{-- <a id="name" class="dropdown-item has-icon" style="cursor: pointer">
                    <i class="fas fa-id-badge"></i> {{ __('Ganti Nama') }}
                </a> --}}
                <a href="{{ route('users.password') }}" class="dropdown-item has-icon">
                    <i class="fas fa-key"></i> {{ __('Ganti Password') }}
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();"
                    class="dropdown-item has-icon text-danger">
                    <i class="fas fa-sign-out-alt"></i> {{ __('auth.logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>