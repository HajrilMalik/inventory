@extends('backend.layouts.master')

@section('title', 'Dashboard - Admin Panel')

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Dashboard</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>Informasi Barang</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>

<div class="main-content-inner">
    <div class="row">
        <div class="col-lg-4 col-md-6 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Total Barang</h4>
                    <h2>{{ $totalBarang }}</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Total Stok</h4>
                    <h2>{{ $totalStok }}</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Total Barang Keluar</h4>
                    <h2>{{ $totalBarangKeluar }}</h2>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Total Pendapatan</h4>
                    <h2>Rp. {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>
    </div>

    @if($lowStockItems->isNotEmpty())
    <div class="row mt-5">
    <div class="card-body alert alert-danger">
                    <h4 class="header-title float-left">Barang Dengan Stok Rendah</h4>
                    <div class="float-right mb-2">
                    </div>
                    <div class="clearfix"></div>
                    <div class="data-tables table-responsive ">
                        <table id="dataTable" class="table text-center">
                            <thead class="bg-red text-capitalize ">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Nama Barang</th>
                                    <th width="10%">Harga</th>
                                    <th width="10%">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lowStockItems as $barang)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $barang->nama_barang }}</td>
                                    <td>{{ $barang->harga }}</td>
                                    <td>{{ $barang->stok }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
    </div>


    @endif
</div>
@endsection