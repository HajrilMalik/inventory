@extends('backend.layouts.master')

@section('title', 'Stok Barang Keluar - Admin Panel')

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Stok Barang Keluar</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>Semua Stok Barang Keluar</span></li>
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
        <!-- data table start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title float-left">Semua Stok Barang Keluar</h4>
                    <div class="float-right mb-2">
                        @if (Auth::guard('admin')->user()->can('barang.create'))
                        <a class="btn btn-primary text-white" href="{{ route('admin.barangKeluars.create') }}">Tambah
                            Barang Keluar Baru</a>
                        @endif

                        <!-- Tombol Export Excel -->
                        <a class="btn btn-success text-white ml-2" href="{{ route('admin.barangKeluars.export') }}">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </a>
                    </div>
                    <div class="clearfix"></div>
                    @include('backend.layouts.partials.messages')
                    <!-- Include success/error messages here -->
                    <div class="data-tables table-responsive">
                        <table id="dataTable" class="table text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Nama Pembeli</th>
                                    <th>Jumlah</th>
                                    <th>Total Transaksi</th>
                                    <th>Biaya Tambahan</th>
                                    <th>Tanggal Keluar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangKeluar as $barang)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $barang->barang->nama_barang }}</td>
                                    <td>{{ $barang->nama_pembeli }}</td>
                                    <td>{{ $barang->jumlah }}</td>
                                    <td>Rp {{ number_format($barang->total_transaksi, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($barang->biaya_tambahan ?? 0, 0, ',', '.') }}</td>
                                    <td>{{ $barang->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td>
                                        @if (Auth::guard('admin')->user()->can('barang.edit'))
                                        <a href="{{ route('admin.barangKeluars.edit', $barang->id) }}"
                                            class="btn btn-success btn-sm">
                                            <i class="fa fa-edit"></i> Ubah
                                        </a>
                                        @endif
                                        @if (Auth::guard('admin')->user()->can('barang.delete'))
                                        <form action="{{ route('admin.barangKeluars.destroy', $barang->id) }}"
                                            method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this item?')">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- data table end -->
    </div>
</div>
@endsection

@section('scripts')
<!-- Start datatable js -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        responsive: true,
        searching: false
    });
});
</script>
@endsection