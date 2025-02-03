@extends('layouts.main')

@section('container')
    <div class="container mt-4">
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

        <!-- Riwayat Peminjaman Section -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Riwayat Peminjaman Anda</h5>
            </div>
            <div class="card-body">
                @if($peminjaman->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($peminjaman->count() > 0)
                                    @foreach($peminjaman as $pinjam)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pinjam->barang->nama_barang }}</td>
                                        <td>{{ $pinjam->jumlah_pinjam }}</td>
                                        <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d/m/Y') }}</td>
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
                                        <td colspan="7" class="text-center">Tidak ada data peminjaman</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0">Anda belum memiliki riwayat peminjaman.</p>
                @endif
            </div>
        </div>

        <!-- Form Peminjaman Section -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Form Peminjaman Barang</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pinjam.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="barang_id" class="form-label">Pilih Barang</label>
                        <select class="form-select @error('barang_id') is-invalid @enderror" id="barang_id" name="barang_id" required>
                            <option value="">Pilih barang...</option>
                            @foreach($barangs as $barang)
                                <option value="{{ $barang->id }}" {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                    {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})
                                </option>
                            @endforeach
                        </select>
                        @error('barang_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jumlah_pinjam" class="form-label">Jumlah Pinjam</label>
                        <input type="number" class="form-control @error('jumlah_pinjam') is-invalid @enderror" id="jumlah_pinjam" name="jumlah_pinjam" value="{{ old('jumlah_pinjam') }}" required min="1">
                        @error('jumlah_pinjam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                        <input type="date" class="form-control @error('tanggal_pinjam') is-invalid @enderror" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}" required>
                        @error('tanggal_pinjam')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                        <input type="date" class="form-control @error('tanggal_kembali') is-invalid @enderror" id="tanggal_kembali" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}" required>
                        @error('tanggal_kembali')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="keperluan" class="form-label">Keperluan</label>
                        <textarea class="form-control @error('keperluan') is-invalid @enderror" id="keperluan" name="keperluan" rows="3" required>{{ old('keperluan') }}</textarea>
                        @error('keperluan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                        <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="2">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Submit Peminjaman</button>
                </form>
            </div>
        </div>
    </div>
@endsection 