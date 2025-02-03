<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index', [
            'title' => 'Dashboard',
            'barangs' => Barang::all()
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kode_barang' => 'required|unique:data_barang',
            'nama_barang' => 'required',
            'merk' => 'required',
            'type' => 'required',
            'spesifikasi' => 'required',
            'stok' => 'required|numeric',
            'satuan' => 'required',
            'lokasi' => 'required',
            'kondisi' => 'required',
            'keterangan' => 'nullable'
        ]);

        Barang::create($validatedData);

        return redirect('/dashboard')->with('success', 'Data barang berhasil ditambahkan!');
    }

    public function show($id)
    {
        return view('dashboard.show', [
            'title' => 'Detail Barang',
            'barang' => Barang::findOrFail($id)
        ]);
    }

    public function edit($id)
    {
        return view('dashboard.edit', [
            'title' => 'Edit Barang',
            'barang' => Barang::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $rules = [
            'nama_barang' => 'required',
            'merk' => 'required',
            'type' => 'required',
            'spesifikasi' => 'required',
            'stok' => 'required|numeric',
            'satuan' => 'required',
            'lokasi' => 'required',
            'kondisi' => 'required',
            'keterangan' => 'nullable'
        ];

        // Only validate kode_barang uniqueness if it's changed
        if ($request->kode_barang != $barang->kode_barang) {
            $rules['kode_barang'] = 'required|unique:data_barang';
        }

        $validatedData = $request->validate($rules);

        $barang->update($validatedData);

        return redirect('/dashboard')->with('success', 'Data barang berhasil diupdate!');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect('/dashboard')->with('success', 'Data barang berhasil dihapus!');
    }
}
