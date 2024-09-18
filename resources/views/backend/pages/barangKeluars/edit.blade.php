@extends('backend.layouts.master')

@section('title', 'Edit Barang Keluar - Admin Panel')

@section('admin-content')
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Edit Barang Keluar</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.barangKeluars.index') }}">Semua Barang Keluar</a></li>
                    <li><span>Edit Barang Keluar</span></li>
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
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Form Edit Barang Keluar</h4>
                    <form action="{{ route('admin.barangKeluars.update', $barangKeluar->id) }}" method="POST"
                        id="form-edit-barang-keluar">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="barang_id">Nama Barang</label>
                            <select name="barang_id" class="form-control" id="barang_id" required>
                                <option value="">Pilih Nama Barang</option>
                                @foreach($barangs as $barang)
                                <option value="{{ $barang->id_barang }}" data-stok="{{ $barang->stok }}"
                                    data-harga="{{ $barang->harga }}"
                                    {{ $barang->id_barang == $barangKeluar->barang_id ? 'selected' : '' }}>
                                    {{ $barang->nama_barang }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="stok_barang">Stok Barang</label>
                            <input type="number" id="stok_barang" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="nama_pembeli">Nama Pembeli</label>
                            <input type="text" name="nama_pembeli" class="form-control" id="nama_pembeli"
                                value="{{ $barangKeluar->nama_pembeli }}" required>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" id="jumlah"
                                value="{{ $barangKeluar->jumlah }}" required>
                            <div class="invalid-feedback" id="error-jumlah" style="display: none;">
                                Jumlah barang keluar melebihi stok yang tersedia.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="total_transaksi">Total Transaksi</label>
                            <input type="number" step="0.01" name="total_transaksi" class="form-control"
                                id="total_transaksi" value="{{ $barangKeluar->total_transaksi }}" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="biaya_tambahan">Biaya Tambahan</label>
                            <input type="number" step="0.01" name="biaya_tambahan" class="form-control"
                                id="biaya_tambahan" value="{{ $barangKeluar->biaya_tambahan }}">
                            <div class="invalid-feedback" id="error-biaya" style="display: none;">
                                Biaya tambahan harus berupa angka yang valid.
                            </div>
                        </div>
                        <div class="alert alert-danger" id="error-message" style="display: none;">
                            Jumlah barang keluar melebihi stok yang tersedia.
                        </div>
                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('barang_id').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];
    var stok = selectedOption.getAttribute('data-stok');
    document.getElementById('stok_barang').value = stok;

    // Hitung ulang total transaksi saat barang dipilih berubah
    calculateTotal();
});

document.getElementById('jumlah').addEventListener('input', function() {
    // Validasi jumlah barang keluar
    validateJumlah();
    // Hitung ulang total transaksi saat jumlah barang keluar berubah
    calculateTotal();
});

document.getElementById('biaya_tambahan').addEventListener('input', function() {
    // Validasi biaya tambahan
    validateBiayaTambahan();
    // Hitung ulang total transaksi saat biaya tambahan berubah
    calculateTotal();
});

function calculateTotal() {
    var selectedOption = document.getElementById('barang_id').options[document.getElementById('barang_id')
        .selectedIndex];
    var hargaBarang = parseFloat(selectedOption.getAttribute('data-harga'));
    var jumlah = parseInt(document.getElementById('jumlah').value);
    var biayaTambahan = parseFloat(document.getElementById('biaya_tambahan').value);

    var totalTransaksi = hargaBarang * jumlah;
    if (!isNaN(totalTransaksi)) {
        if (!isNaN(biayaTambahan)) {
            totalTransaksi += biayaTambahan;
        }
        document.getElementById('total_transaksi').value = totalTransaksi.toFixed(2);
    }
}

function validateJumlah() {
    var selectedOption = document.getElementById('barang_id').options[document.getElementById('barang_id')
        .selectedIndex];
    var stok = parseInt(selectedOption.getAttribute('data-stok'));
    var jumlah = parseInt(document.getElementById('jumlah').value);

    if (jumlah > stok) {
        document.getElementById('error-jumlah').style.display = 'block';
    } else {
        document.getElementById('error-jumlah').style.display = 'none';
    }
}

function validateBiayaTambahan() {
    var biayaTambahan = document.getElementById('biaya_tambahan').value;

    if (isNaN(biayaTambahan) && biayaTambahan !== '') {
        document.getElementById('error-biaya').style.display = 'block';
    } else {
        document.getElementById('error-biaya').style.display = 'none';
    }
}

document.getElementById('form-edit-barang-keluar').addEventListener('submit', function(event) {
    // Validasi jumlah barang keluar
    validateJumlah();
    // Validasi biaya tambahan
    validateBiayaTambahan();

    var errorJumlah = document.getElementById('error-jumlah').style.display === 'block';
    var errorBiaya = document.getElementById('error-biaya').style.display === 'block';

    if (errorJumlah || errorBiaya) {
        event.preventDefault(); // Mencegah pengiriman form jika ada error
    }
});
</script>
@endsection