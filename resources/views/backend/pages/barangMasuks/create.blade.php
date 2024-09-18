@extends('backend.layouts.master')

@section('title', 'Tambah Barang Masuk - Admin Panel')

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Tambah Barang Masuk</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><span>Barang Masuk</span></li>
                    <li><span>Tambah</span></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="main-content-inner">
    <div class="row">
        <div class="col-lg-12 col-ml-12">
            <div class="row">
                <!-- Textual inputs start -->
                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Tambah Barang Masuk</h4>
                            <form action="{{ route('admin.barangMasuks.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="barang_id">Nama Barang</label>
                                    <select name="barang_id" id="barang_id" class="form-control @error('barang_id') is-invalid @enderror">
                                        <option value="">-- Pilih Barang --</option>
                                        @foreach ($barangs as $barang)
                                        <option value="{{ $barang->id_barang }}" {{ old('barang_id') == $barang->id_barang ? 'selected' : '' }}>{{ $barang->nama_barang }}</option>
                                        @endforeach
                                    </select>
                                    @error('barang_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="nama_pemasuk">Nama Pemasuk</label>
                                    <input type="text" name="nama_pemasuk" id="nama_pemasuk" class="form-control @error('nama_pemasuk') is-invalid @enderror" value="{{ old('nama_pemasuk') }}">
                                    @error('nama_pemasuk')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="stok">Stok</label>
                                    <input type="number" name="stok" id="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok') }}">
                                    @error('stok')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Textual inputs end -->
            </div>
        </div>
    </div>
</div>
@endsection