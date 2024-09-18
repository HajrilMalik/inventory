@extends('backend.layouts.master')

@section('title', 'Stok Barang - Admin Panel')

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Stok Barang</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>Semua Stok Barang</span></li>
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
                    <h4 class="header-title float-left">Semua Stok Barang</h4>
                    <div class="float-right mb-2">
                        @if (Auth::guard('admin')->user()->can('stok.create'))
                        <a class="btn btn-primary text-white" href="{{ route('admin.stokBarangs.create') }}">Tambah
                            Barang Baru</a>
                        @endif

                        <!-- Tombol Export Excel -->
                        <a class="btn btn-success text-white ml-2" href="{{ route('admin.stokBarangs.export') }}">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </a>
                    </div>
                    <div class="clearfix"></div>
                    <div class="data-tables table-responsive">
                        @include('backend.layouts.partials.messages')
                        <table id="dataTable" class="table text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Nama Barang</th>
                                    <th width="20%">Deskripsi</th>
                                    <th width="10%">Harga</th>
                                    <th width="10%">Stok</th>
                                    <th width="20%">Gambar</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stokBarangs as $barang)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $barang->nama_barang }}</td>
                                    <td>{{ $barang->deskripsi }}</td>
                                    <td>{{ $barang->harga }}</td>
                                    <td>{{ $barang->stok }}</td>
                                    <td>
                                        @if($barang->gambar)
                                        <img src="{{ asset('storage/' . $barang->gambar) }}" width="50"
                                            alt="gambar thumbnail">
                                        @else
                                        <span>No Image</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (Auth::guard('admin')->user()->can('stok.edit'))
                                        <a href="{{ route('admin.stokBarangs.edit', $barang->id_barang) }}"
                                            class="btn btn-success btn-sm">
                                            <i class="fa fa-edit"></i> Ubah
                                        </a>
                                        @endif
                                        @if (Auth::guard('admin')->user()->can('stok.delete'))
                                        <form action="{{ route('admin.stokBarangs.destroy', $barang->id_barang) }}"
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
/*================================
        datatable active
==================================*/
if ($('#dataTable').length) {
    $('#dataTable').DataTable({
        responsive: true,
        searching: false
    });
}

function openInNewTab(event) {
    event.preventDefault();
    var url = event.currentTarget.href;
    window.open(url, '_blank');
}
</script>
@endsection