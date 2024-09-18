<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BarangKeluarExport;
use Illuminate\Support\Facades\Auth;



class BarangKeluarController extends Controller
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
        if (is_null($this->user) || !$this->user->can('barang.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view the dashboard!');
        }
        
        $barangKeluar = BarangKeluar::with('barang')->get();
        return view('backend.pages.barangKeluars.index', compact('barangKeluar'));
    }

    public function create()
    {
        if (is_null($this->user) || !$this->user->can('barang.create')) {
            abort(403, 'Sorry !! You are Unauthorized to view the dashboard!');
        }

        $barangs = Barang::all();
        return view('backend.pages.barangKeluars.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'barang_id' => 'required|exists:barang,id_barang',
            'nama_pembeli' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'total_transaksi' => 'required|numeric',
            'biaya_tambahan' => 'nullable|numeric',
        ]);

        // Retrieve the Barang item
        $barang = Barang::findOrFail($request->barang_id);

        // Check if there is enough stock
        if ($request->jumlah > $barang->stok) {
            return back()->withErrors(['jumlah' => 'Jumlah barang keluar melebihi stok yang tersedia.']);
        }

        // Create the Barang Keluar entry
        BarangKeluar::create([
            'barang_id' => $request->barang_id,
            'nama_pembeli' => $request->nama_pembeli,
            'jumlah' => $request->jumlah,
            'total_transaksi' => $request->total_transaksi,
            'biaya_tambahan' => $request->biaya_tambahan,
        ]);

        // Update the stock
        $barang->stok -= $request->jumlah;
        $barang->save();

        return redirect()->route('admin.barangKeluars.index')->with('success', 'Barang Keluar berhasil ditambahkan.');
    }
    

    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('barang.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to view the dashboard!');
        }
        
        $barangKeluar = BarangKeluar::findOrFail($id);
        $barangs = Barang::all();
    
        return view('backend.pages.barangKeluars.edit', compact('barangKeluar', 'barangs'));
    }
    

    public function update(Request $request, $id)
    {
        // Validasi request
        $request->validate([
            'barang_id' => 'required',
            'nama_pembeli' => 'required',
            'jumlah' => 'required|numeric|min:1',
            'total_transaksi' => 'required|numeric|min:0',
            'biaya_tambahan' => 'nullable|numeric|min:0',
        ]);

        // Ambil data barang keluar berdasarkan ID
        $barangKeluar = BarangKeluar::findOrFail($id);

        // Ambil barang dari database berdasarkan ID
        $barang = Barang::findOrFail($request->barang_id);

        // Hitung selisih jumlah barang keluar baru dengan yang lama
        $selisihJumlah = $request->jumlah - $barangKeluar->jumlah;

        // Validasi jumlah barang keluar tidak melebihi stok yang ada
        if ($selisihJumlah > $barang->stok) {
            return redirect()->back()->with('error', 'Jumlah barang keluar melebihi stok yang tersedia.');
        }

        // Update stok barang yang terkait
        $barang->stok -= $selisihJumlah;
        $barang->save();

        // Update data barang keluar
        $barangKeluar->barang_id = $request->barang_id;
        $barangKeluar->nama_pembeli = $request->nama_pembeli;
        $barangKeluar->jumlah = $request->jumlah;
        $barangKeluar->total_transaksi = $request->total_transaksi;
        $barangKeluar->biaya_tambahan = $request->biaya_tambahan;
        $barangKeluar->save();

        return redirect()->route('admin.barangKeluars.index')->with('success', 'Barang keluar berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('barang.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to view the dashboard!');
        }
        
        $barangKeluar = BarangKeluar::findOrFail($id);
        $barangKeluar->delete();

        return redirect()->route('admin.barangKeluars.index')->with('success', 'Barang Keluar berhasil dihapus.');
    }

    public function export()
    {
        return Excel::download(new BarangKeluarExport, 'barang_keluar.xlsx');
    }
}   