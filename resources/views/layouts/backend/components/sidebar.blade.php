<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">{{ __('pages.title') }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/') }}">{{ __('pages.brand') }}</a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::route()->getName() == 'dashboard' ? 'active' : (
                Request::route()->getName() == 'dashboard.log' ? 'active' : '') }}">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="fas fa-fire"></i><span>{{ __('pages.dashboard') }}</span>
                </a>
            </li>
            <li class="menu-header">{{ __('Transaksi') }}</li>
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Service'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Selling'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Purchasing'])
{{--             @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>Request::route()->getName() == 'creditFunds.index' ? 'active' :'',
            'url'=>route('creditFunds.index'), 'title' => 'Credit Funds']) --}}
           
            <li class="menu-header">{{ __('Master Data') }}</li>
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Barang'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Hak Akses'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Cabang'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Kategori'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Supplier'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Biaya'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Kas'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Area'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Unit'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Biaya Pengeluaran'])
           {{--  @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire'
            ,'activeURL'=>Request::route()->getName() == 'item.index' ? 'active' :'',
            'url'=>route('item.index'), 'title' => 'Data Barang']) --}}
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Karyawan'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire',
            'activeURL'=>Request::route()->getName() == 'users.index' ? 'active' :'',
            'url'=>route('users.index'), 'title' => 'User'])

            <li class="menu-header">{{ __('Gudang') }}</li>
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Stock'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Stock Masuk'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Stock Keluar'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Stock Opname'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Stock Mutasi'])

            <li class="menu-header">{{ __('Konten') }}</li>
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Carousel'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Konten'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Note'])

            {{--  <li class="menu-header">{{ __('Laporan') }}</li>
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Data Anggota'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Kas Anggota'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Jatuh Tempo'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Kredit Macet'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Transaksi Kas'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Buku Besar'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Neraca Saldo'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Kas Simpanan'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Kas Pinjaman'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Saldo Kas'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'Laba Rugi'])
            @include('layouts.backend.components.sidebarMenu',
            ['icon' => 'fa-fire','activeURL'=>'','url'=>'javascript:void(0)', 'title' => 'SHU']) --}}
        </ul>
    </aside>
</div>