<?php

namespace App\Http\Controllers;

use App\Models\MasterTindakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterTIndakanController extends Controller
{
    public function index()
    {
        // Check if user is logged in first
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('cost.MasterTindakan', [
            'title' => 'Master Tindakan',
            'tindakan' => MasterTindakan::latest()->get(),
            'peminjaman' => collect([]) // Empty collection for now since this view is for tindakan
        ]);
    }

    public function create()
    {
        // Check if user is logged in first
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('master.tindakan.create', [
            'title' => 'Tambah Tindakan'
        ]);
    }

    public function store(Request $request)
    {
        // Check if user is logged in first
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validatedData = $request->validate([
            'kode_tindakan' => 'required|string|max:20|unique:master_tindakan',
            'nama_tindakan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'jenis_tindakan' => 'required|string|max:255',
            'group_tindakan' => 'required|in:Paket,non_paket',
        ]);

        MasterTindakan::create($validatedData);

        return redirect('/master/tindakan')->with('success', 'Data tindakan berhasil ditambahkan!');
    }

    public function show(MasterTindakan $tindakan)
    {
        // Check if user is logged in first
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('master.tindakan.show', [
            'title' => 'Detail Tindakan',
            'tindakan' => $tindakan
        ]);
    }

    public function edit(MasterTindakan $tindakan)
    {
        // Check if user is logged in first
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('master.tindakan.edit', [
            'title' => 'Edit Tindakan',
            'tindakan' => $tindakan
        ]);
    }

    public function update(Request $request, MasterTindakan $tindakan)
    {
        // Check if user is logged in first
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $rules = [
            'nama_tindakan' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'jenis_tindakan' => 'required|string|max:255',
            'group_tindakan' => 'required|in:Paket,non_paket',
        ];

        // Only validate kode_tindakan if it's changed
        if ($request->kode_tindakan != $tindakan->kode_tindakan) {
            $rules['kode_tindakan'] = 'required|string|max:20|unique:master_tindakan';
        }

        $validatedData = $request->validate($rules);

        MasterTindakan::where('id', $tindakan->id)->update($validatedData);

        return redirect('/master/tindakan')->with('success', 'Data tindakan berhasil diperbarui!');
    }

    public function destroy(MasterTindakan $tindakan)
    {
        // Check if user is logged in first
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        MasterTindakan::destroy($tindakan->id);

        return redirect('/master/tindakan')->with('success', 'Data tindakan berhasil dihapus!');
    }
} 