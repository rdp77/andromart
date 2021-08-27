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
            {{-- Transaksi --}}
            <li class="nav-item dropdown">
                <a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-exchange-alt"></i>
                    <span>{{ __('Transaksi') }}</span>
                </a>
                <ul class="dropdown-menu">
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Service',
                    'url'=>route('service.index')])
                    @include('layouts.backend.components.sidebarMenu',[
                        'active'=>'',
                        'title'=>'Update WO Service',
                        'url'=>route('service.serviceFormUpdateStatus')])
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Penjualan',
                    'url'=>route('sale.index')])
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Pembelian',
                    'url'=>''])
                </ul>
            </li>
            {{-- Master Data --}}
            <li class="nav-item dropdown">
                <a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-database"></i>
                    <span>{{ __('Master Data') }}</span>
                </a>
                <ul class="dropdown-menu">
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Area',
                    'url'=>route('area.index')])
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Cabang',
                    'url'=>route('branch.index')])
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Kategori',
                    'url'=>route('category.index')])
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Barang',
                    'url'=>route('item.index')])
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Hak Akses',
                    'url'=>''])
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Supplier',
                    'url'=>route('supplier.index')])
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Biaya',
                    'url'=>route('cost.index')])
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Kas',
                    'url'=>route('cash.index')])
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Satuan',
                    'url'=>route('unit.index')])
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Biaya Pengeluaran',
                    'url'=>''])
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Karyawan',
                    'url'=>''])
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'User',
                    'url'=>route('users.index')])
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Pelanggan',
                    'url'=>route('customer.index')])
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Warranty',
                    'url'=>route('warranty.index')])
                </ul>
            </li>
            {{-- Gudang --}}
            <li class="nav-item dropdown">
                <a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-boxes"></i>
                    <span>{{ __('Gudang') }}</span>
                </a>
                <ul class="dropdown-menu">
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Stok',
                    'url'=>''])
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Stok Masuk',
                    'url'=>''])
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Stok Keluar',
                    'url'=>''])
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Stok Opname',
                    'url'=>''])
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Stok Mutasi',
                    'url'=>''])
                </ul>
            </li>
            {{-- Konten --}}
            <li class="nav-item dropdown">
                <a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-file-alt"></i>
                    <span>{{ __('Konten') }}</span>
                </a>
                <ul class="dropdown-menu">
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Carousel',
                    'url'=>''])
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Konten',
                    'url'=>''])
                    @include('layouts.backend.components.sidebarMenu',[
                    'active'=>'',
                    'title'=>'Notulen',
                    'url'=>route('notes.index')])
                </ul>
            </li>
        </ul>
    </aside>
</div>
