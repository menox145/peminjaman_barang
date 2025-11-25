<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class PinjamController extends Controller
{
    public function index()
    {
        // Check if user is logged in first
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('pinjam.index', [
            'title' => 'Daftar Peminjaman',
            'peminjaman' => Peminjaman::with(['barang', 'user'])->latest()->get(),
            'barangs' => Barang::where('stok', '>', 0)->get()
        ]);
    }

    public function create()
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // For regular users, show their borrowing history and the form
        return view('pinjam.form', [
            'title' => 'Form Peminjaman',
            'barangs' => Barang::where('stok', '>', 0)->get(),
            'peminjaman' => Peminjaman::where('user_id', Auth::id())
                ->with('barang')
                ->latest()
                ->get()
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'unit_bagian' => 'required|string|in:ranap,keuangan,rajal,adm,igd,icu,Kedokteran',
            'barang_id' => 'required|exists:data_barang,id',
            'jumlah_pinjam' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_pinjam',
            'keperluan' => 'required|string'
        ]);

        $barang = Barang::find($request->barang_id);

        if ($barang->stok < $request->jumlah_pinjam) {
            return back()->withInput()
                ->withErrors(['jumlah_pinjam' => 'Stok barang tidak mencukupi!']);
        }

        // Generate username from name (lowercase, remove spaces)
        $username = strtolower(str_replace(' ', '', $validatedData['name'])) . rand(100, 999);

        // Generate email from username
        $email = $username . '@example.com';

        // Create or find user
        $user = User::firstOrCreate(
            ['username' => $username],
            [
                'name' => $validatedData['name'],
                'username' => $username,
                'email' => $email,
                'password' => bcrypt('password'), // Set a default password
                // Tidak perlu is_admin
                'unit_bagian' => $validatedData['unit_bagian']
            ]
        );

        // Remove name and unit_bagian from validated data
        unset($validatedData['name']);
        unset($validatedData['unit_bagian']);

        $validatedData['user_id'] = $user->id;
        $validatedData['status'] = 'dipinjam';
        $validatedData['tanggal_pinjam'] = Carbon::parse($request->tanggal_pinjam)->format('Y-m-d');
        $validatedData['tanggal_kembali'] = Carbon::parse($request->tanggal_kembali)->format('Y-m-d');

        // Kurangi stok barang
        $barang->stok -= $request->jumlah_pinjam;
        $barang->save();

        Peminjaman::create($validatedData);

        return redirect()->back()->with('success', 'Peminjaman barang berhasil diajukan!');
    }

    public function show(Peminjaman $pinjam)
    {
        // Check if user is logged in first
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('pinjam.show', [
            'title' => 'Detail Peminjaman',
            'pinjam' => $pinjam
        ]);
    }

    public function return(Peminjaman $pinjam)
    {
        // Check if user is logged in first
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($pinjam->status !== 'dipinjam') {
            return back()->with('error', 'Barang sudah dikembalikan atau dibatalkan!');
        }

        $pinjam->update(['status' => 'dikembalikan']);

        // Kembalikan stok barang
        $barang = $pinjam->barang;
        $barang->stok += $pinjam->jumlah_pinjam;
        $barang->save();

        return redirect('/pinjam')->with('success', 'Barang berhasil dikembalikan!');
    }

    public function destroy(Peminjaman $pinjam)
    {
        // Check if user is logged in first
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($pinjam->status !== 'dipinjam') {
            return back()->with('error', 'Peminjaman tidak dapat dibatalkan!');
        }

        // Kembalikan stok barang
        $barang = $pinjam->barang;
        $barang->stok += $pinjam->jumlah_pinjam;
        $barang->save();

        // Update status menjadi batal
        $pinjam->update(['status' => 'batal']);

        return redirect('/pinjam')->with('success', 'Peminjaman berhasil dibatalkan!');
    }
}
