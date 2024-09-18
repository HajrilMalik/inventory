<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Exports\StokBarangExport;
use Maatwebsite\Excel\Facades\Excel;


class StokBarangsController extends Controller
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
        if (is_null($this->user) || !$this->user->can('stok.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any master data!');
        }
        // Fetch all stok barang items
        $stokBarangs = Barang::all();

        // Pass the data to the view
        return view('backend.pages.stokBarangs.index', compact('stokBarangs'));
    }

    public function create()
    {
        if (is_null($this->user) || !$this->user->can('stok.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data!');
        }

        return view('backend.pages.stokBarangs.create');
    }

    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('stok.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any master data!');
        }

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000',
        ]);

        // Check if a file is uploaded before validating image
        if ($request->hasFile('gambar')) {
            $request->validate([
                'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:5000',
            ]);
        }

        $barang = new Barang();
        $barang->nama_barang = $request->nama_barang;
        $barang->deskripsi = $request->deskripsi;
        $barang->harga = $request->harga;
        $barang->stok = $request->stok;

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('barang', 'public');
            $barang->gambar = $path;
        }

        $barang->save();

        return redirect()->route('admin.stokBarangs.index')->with('success', 'Barang created successfully.');
    }

    public function edit($id)
{
    if (is_null($this->user) || !$this->user->can('stok.edit')) {
        abort(403, 'Sorry !! You are Unauthorized to edit any master data!');
    }

    $barang = Barang::findOrFail($id);

    return view('backend.pages.stokBarangs.edit', compact('barang'));
}

public function update(Request $request, $id)
{
    if (is_null($this->user) || !$this->user->can('stok.edit')) {
        abort(403, 'Sorry !! You are Unauthorized to edit any master data!');
    }

    $request->validate([
        'nama_barang' => 'required|string|max:255',
        'deskripsi' => 'nullable|string',
        'harga' => 'required|numeric',
        'stok' => 'required|integer',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000',
    ]);
    
    // Check if a file is uploaded before validating image
    if ($request->hasFile('gambar')) {
        $request->validate([
            'gambar' => 'image|mimes:jpeg,png,jpg,gif|max:5000',
        ]);
    }

    $barang = Barang::findOrFail($id);
    $barang->nama_barang = $request->nama_barang;
    $barang->deskripsi = $request->deskripsi;
    $barang->harga = $request->harga;
    $barang->stok = $request->stok;

    if ($request->hasFile('gambar')) {
        // Delete the old image if exists
        if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
            Storage::disk('public')->delete($barang->gambar);
        }
        $path = $request->file('gambar')->store('barang', 'public');
        $barang->gambar = $path;
    }

    $barang->save();

    return redirect()->route('admin.stokBarangs.index')->with('success', 'Barang updated successfully.');
}

    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('stok.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any master data!');
        }

        $barang = Barang::findOrFail($id);

        // Delete the image
        if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
            Storage::disk('public')->delete($barang->gambar);
        }

        $barang->delete();

        return redirect()->route('admin.stokBarangs.index')->with('success', 'Barang deleted successfully.');
    }
    public function export()
    {
        return Excel::download(new StokBarangExport, 'stok_barang.xlsx');
    }

}