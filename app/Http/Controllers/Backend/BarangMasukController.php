<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BarangMasukExport;
use Illuminate\Support\Facades\Auth;

class BarangMasukController extends Controller
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

        $barangMasuk = BarangMasuk::with('barang')->get();
        return view('backend.pages.barangMasuks.index', compact('barangMasuk'));
    }

    public function create()
    {
        if (is_null($this->user) || !$this->user->can('barang.create')) {
            abort(403, 'Sorry !! You are Unauthorized to view the dashboard!');
        }

        $barangs = Barang::all();
        return view('backend.pages.barangMasuks.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'barang_id' => 'required|exists:barang,id_barang',
            'nama_pemasuk' => 'required|string|max:255',
            'stok' => 'required|integer|min:1',
        ]);

        // Update the stock quantity
        $barang = Barang::find($request->barang_id);
        $barang->stok += $request->stok;
        $barang->save();

        // Create the Barang Masuk entry
        BarangMasuk::create([
            'barang_id' => $request->barang_id,
            'nama_pemasuk' => $request->nama_pemasuk,
            'stok' => $request->stok,
        ]);

        return redirect()->route('admin.barangMasuks.index')->with('success', 'Barang Masuk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('barang.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to view the dashboard!');
        }

        $barangMasuk = BarangMasuk::findOrFail($id);
        $barangs = Barang::all();

        return view('backend.pages.barangMasuks.edit', compact('barangMasuk', 'barangs'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'barang_id' => 'required',
            'nama_pemasuk' => 'required',
            'stok' => 'required|integer|min:1',
        ]);

        // Update the stock quantity
        $barang = Barang::find($request->barang_id);
        $barang->stok += $request->stok;
        $barang->save();

        // Update the Barang Masuk entry
        $barangMasuk = BarangMasuk::findOrFail($id);
        $barangMasuk->barang_id = $request->barang_id;
        $barangMasuk->nama_pemasuk = $request->nama_pemasuk;
        $barangMasuk->stok = $request->stok;
        $barangMasuk->save();

        return redirect()->route('admin.barangMasuks.index')->with('success', 'Barang Masuk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('barang.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to view the dashboard!');
        }

        $barangMasuk = BarangMasuk::findOrFail($id);
        $barangMasuk->delete();

        return redirect()->route('admin.barangMasuks.index')->with('success', 'Barang Masuk berhasil dihapus.');
    }

    public function export()
    {
        return Excel::download(new BarangMasukExport, 'barang.xlsx');
    }
}