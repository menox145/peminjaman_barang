<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    // ==============================
    // INDEX - MENAMPILKAN LIST DATA
    // ==============================
    public function index()
    {
        $services = Service::orderBy('id', 'DESC')->get();
        return view('service.index', compact('services'));
    }

    // ==============================
    // FORM CREATE
    // ==============================
    public function create()
    {
        return view('service.create');
    }

    // ==============================
    // SIMPAN DATA BARU
    // ==============================
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'brand'         => 'required',
            'model'         => 'required',
            'status'        => 'required',
            'tanggal_masuk' => 'required|date'
        ]);

        Service::create([
            'customer_name' => $request->customer_name,
            'no_hp'         => $request->no_hp,
            'brand'         => $request->brand,
            'model'         => $request->model,
            'keluhan'       => $request->keluhan,
            'analisa_teknisi' => $request->analisa_teknisi,
            'biaya'         => $request->biaya,
            'status'        => $request->status,
            'tanggal_masuk' => $request->tanggal_masuk,
            'tanggal_selesai' => $request->tanggal_selesai
        ]);

        return redirect()->route('service.index')->with('success', 'Data service berhasil ditambahkan!');
    }

    // ==============================
    // TAMPILKAN DETAIL
    // ==============================
    public function show($id)
    {
        $srv = Service::findOrFail($id);
        return view('service.show', compact('srv'));
    }

    // ==============================
    // FORM EDIT
    // ==============================
    public function edit($id)
    {
        $srv = Service::findOrFail($id);
        return view('service.edit', compact('srv'));
    }

    // ==============================
    // UPDATE
    // ==============================
    public function update(Request $request, $id)
    {
        $srv = Service::findOrFail($id);

        $srv->update([
            'customer_name' => $request->customer_name,
            'no_hp'         => $request->no_hp,
            'brand'         => $request->brand,
            'model'         => $request->model,
            'keluhan'       => $request->keluhan,
            'analisa_teknisi' => $request->analisa_teknisi,
            'biaya'         => $request->biaya,
            'status'        => $request->status,
            'tanggal_masuk' => $request->tanggal_masuk,
            'tanggal_selesai' => $request->tanggal_selesai
        ]);

        return redirect()->route('service.index')->with('success', 'Data service berhasil diupdate!');
    }

    // ==============================
    // DELETE
    // ==============================
    public function destroy($id)
    {
        $srv = Service::findOrFail($id);
        $srv->delete();

        return redirect()->route('service.index')->with('success', 'Data service berhasil dihapus!');
    }
}
