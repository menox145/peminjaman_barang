@extends('layouts.main')

@section('container')
<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Daftar Peminjaman Barang</h2>
                <a href="{{ route('pinjam.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Peminjaman
                </a>
            </div>
        </div>
    </div>

    @if(session()->has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session()->has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Peminjam</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Keperluan</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($peminjaman->count() > 0)
                                    @foreach($peminjaman as $pinjam)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pinjam->user->name }}</td>
                                        <td>{{ $pinjam->barang->nama_barang }}</td>
                                        <td>{{ $pinjam->jumlah_pinjam }}</td>
                                        <td>{{ date('d/m/Y', strtotime($pinjam->tanggal_pinjam)) }}</td>
                                        <td>{{ date('d/m/Y', strtotime($pinjam->tanggal_kembali)) }}</td>
                                        <td>{{ $pinjam->keperluan }}</td>
                                        <td>
                                            @if($pinjam->status == 'dipinjam')
                                                <span class="badge bg-warning">Dipinjam</span>
                                            @elseif($pinjam->status == 'dikembalikan')
                                                <span class="badge bg-success">Dikembalikan</span>
                                            @else
                                                <span class="badge bg-danger">Dibatalkan</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="/pinjam/{{ $pinjam->id }}" class="badge bg-info text-decoration-none">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                            
                                            @if($pinjam->status == 'dipinjam')
                                                <form action="/pinjam/{{ $pinjam->id }}/return" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="badge bg-success border-0" onclick="return confirm('Kembalikan barang ini?')">
                                                        <i class="bi bi-arrow-return-left"></i> Kembalikan
                                                    </button>
                                                </form>

                                                <form action="/pinjam/{{ $pinjam->id }}" method="POST" class="d-inline">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="badge bg-danger border-0" onclick="return confirm('Yakin ingin membatalkan peminjaman?')">
                                                        <i class="bi bi-x-circle"></i> Batal
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" class="text-center">Tidak ada data peminjaman</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 