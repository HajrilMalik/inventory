<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\DataPemohon;
use App\Models\StatusPendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Barang;
use App\Models\BarangKeluar;

class DashboardController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('admin')->user();
            return $next($request);
        });
    }
    
    public function index()
    {
    
        $totalBarang = Barang::count();
        $totalStok = Barang::sum('stok');
        $totalBarangKeluar = BarangKeluar::count();
        $totalPendapatan = BarangKeluar::sum('total_transaksi');
    
        // Definisikan ambang batas stok rendah, misalnya 10
        $threshold = 10;
        // Dapatkan semua barang dengan stok di bawah ambang batas
        $lowStockItems = Barang::where('stok', '<=', $threshold)->get();
    
        return view('backend.pages.dashboard.index', compact('totalBarang', 'totalStok', 'totalBarangKeluar', 'totalPendapatan', 'lowStockItems'));
    }
    
    
}