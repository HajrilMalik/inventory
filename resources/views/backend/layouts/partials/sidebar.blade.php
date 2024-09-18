<!-- sidebar menu area start -->
@php
$usr = Auth::guard('admin')->user();
@endphp
<div class="sidebar-menu">
    <div class="sidebar-header">
        <div class="logo">
            <a href="{{ route('admin.dashboard') }}">
                <h3 class="text-white">Zee Bakers</h3>
            </a>
        </div>
    </div>
    <div class="main-menu">
        <div class="menu-inner">
            <nav>
                <ul class="metismenu" id="menu">

                    <li class="active">
                        <a href="javascript:void(0)" aria-expanded="true"><i
                                class="ti-dashboard"></i><span>dashboard</span></a>
                        <ul class="collapse">
                            <li class="{{ Route::is('admin.dashboard') ? 'active' : '' }}"><a
                                    href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        </ul>
                    </li>

                    @if ($usr->can('role.create') || $usr->can('role.view') || $usr->can('role.edit') ||
                    $usr->can('role.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-tasks"></i><span>
                                Roles & Permissions
                            </span></a>
                        <ul
                            class="collapse {{ Route::is('admin.roles.create') || Route::is('admin.roles.index') || Route::is('admin.roles.edit') || Route::is('admin.roles.show') ? 'in' : '' }}">
                            @if ($usr->can('role.view'))
                            <li
                                class="{{ Route::is('admin.roles.index')  || Route::is('admin.roles.edit') ? 'active' : '' }}">
                                <a href="{{ route('admin.roles.index') }}">Semua Role</a>
                            </li>
                            @endif
                            @if ($usr->can('role.create'))
                            <li class="{{ Route::is('admin.roles.create')  ? 'active' : '' }}"><a
                                    href="{{ route('admin.roles.create') }}">Buat Role</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif


                    @if ($usr->can('admin.create') || $usr->can('admin.view') || $usr->can('admin.edit') ||
                    $usr->can('admin.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-users"></i><span>
                                Akun Pengguna
                            </span></a>
                        <ul
                            class="collapse {{ Route::is('admin.admins.create') || Route::is('admin.admins.index') || Route::is('admin.admins.edit') || Route::is('admin.admins.show') ? 'in' : '' }}">

                            @if ($usr->can('admin.view'))
                            <li
                                class="{{ Route::is('admin.admins.index')  || Route::is('admin.admins.edit') ? 'active' : '' }}">
                                <a href="{{ route('admin.admins.index') }}">Semua Akun</a>
                            </li>
                            @endif

                            @if ($usr->can('admin.create'))
                            <li class="{{ Route::is('admin.admins.create')  ? 'active' : '' }}"><a
                                    href="{{ route('admin.admins.create') }}">Buat Akun</a></li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    @if ($usr->can('stok.create') || $usr->can('stok.view') ||
                    $usr->can('stok.edit') ||
                    $usr->can('stok.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-cubes"></i><span>
                                Stok
                            </span></a>
                        <ul
                            class="collapse {{ Route::is('admin.stokBarangs.create') || Route::is('admin.stokBarangs.index') || Route::is('admin.stokBarangs.edit') || Route::is('admin.stokBarangs.show') ? 'in' : '' }}">

                            @if ($usr->can('stok.view'))
                            <li
                                class="{{ Route::is('admin.stokBarangs.index') || Route::is('admin.stokBarangs.edit') ? 'active' : '' }}">
                                <a href="{{ route('admin.stokBarangs.index') }}">Stok Barang</a>
                            </li>
                            @endif

                        </ul>
                    </li>
                    @endif


                    @if ($usr->can('barang.create') || $usr->can('barang.view') ||
                    $usr->can('barang.edit') ||
                    $usr->can('barang.delete'))
                    <li>
                        <a href="javascript:void(0)" aria-expanded="true"><i class="fa fa-edit"></i><span>
                                Transaksi Barang
                            </span></a>
                        <ul
                            class="collapse {{ Route::is('admin.barangKeluars.create') || Route::is('admin.barangKeluars.index') || Route::is('admin.barangKeluars.edit') || Route::is('admin.barangKeluars.show') ? 'in' : '' }}">

                            @if ($usr->can('barang.view'))
                            <li
                                class="{{ Route::is('admin.barangKeluars.index') || Route::is('admin.barangKeluars.edit') ? 'active' : '' }}">
                                <a href="{{ route('admin.barangKeluars.index') }}">Barang Keluar</a>
                            </li>
                            @endif

                        </ul>
                        <ul
                            class="collapse {{ Route::is('admin.barangMasuks.create') || Route::is('admin.barangMasuks.index') || Route::is('admin.barangMasuks.edit') || Route::is('admin.barangMasuks.show') ? 'in' : '' }}">

                            @if ($usr->can('barang.view'))
                            <li
                                class="{{ Route::is('admin.barangMasuks.index') || Route::is('admin.barangMasuks.edit') ? 'active' : '' }}">
                                <a href="{{ route('admin.barangMasuks.index') }}">Barang Masuk</a>
                            </li>
                            @endif

                        </ul>

                    </li>
                    @endif

                </ul>
            </nav>
        </div>
    </div>
</div>
<!-- sidebar menu area end -->