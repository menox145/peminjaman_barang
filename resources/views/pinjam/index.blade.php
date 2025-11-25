@extends('layouts.main')

@section('container')
    <div class="container mt-4">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Form Peminjaman Section -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Form Peminjaman Barang</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pinjam.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Peminjam</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" required value="{{ old('name') }}" autocomplete="name">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="unit_bagian" class="form-label">Unit/Bagian</label>
                                <select class="form-select @error('unit_bagian') is-invalid @enderror" id="unit_bagian"
                                    name="unit_bagian" required>
                                    <option value="">Pilih Unit/Bagian...</option>
                                    <option value="ranap" {{ old('unit_bagian') == 'ranap' ? 'selected' : '' }}>Rawat Inap
                                    </option>
                                    <option value="keuangan" {{ old('unit_bagian') == 'keuangan' ? 'selected' : '' }}>
                                        Keuangan</option>
                                    <option value="rajal" {{ old('unit_bagian') == 'rajal' ? 'selected' : '' }}>Rawat Jalan
                                    </option>
                                    <option value="adm" {{ old('unit_bagian') == 'adm' ? 'selected' : '' }}>Adm Medis
                                    </option>
                                    <option value="igd" {{ old('unit_bagian') == 'igd' ? 'selected' : '' }}>IGD</option>
                                    <option value="icu" {{ old('unit_bagian') == 'icu' ? 'selected' : '' }}>ICU</option>
                                    <option value="Kedokteran" {{ old('unit_bagian') == 'Kedokteran' ? 'selected' : '' }}>
                                        Kedokteran</option>
                                </select>
                                @error('unit_bagian')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="barang_id" class="form-label">Pilih Barang</label>
                                <select class="form-select @error('barang_id') is-invalid @enderror" id="barang_id"
                                    name="barang_id" required autocomplete="off">
                                    <option value="">Pilih Barang</option>
                                    @foreach ($barangs as $barang)
                                        <option value="{{ $barang->id }}"
                                            {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                            {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('barang_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jumlah_pinjam" class="form-label">Jumlah Pinjam</label>
                                <input type="number" class="form-control @error('jumlah_pinjam') is-invalid @enderror"
                                    id="jumlah_pinjam" name="jumlah_pinjam" required value="{{ old('jumlah_pinjam') }}"
                                    min="1" autocomplete="off">
                                @error('jumlah_pinjam')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                                <input type="date" class="form-control @error('tanggal_pinjam') is-invalid @enderror"
                                    id="tanggal_pinjam" name="tanggal_pinjam" required
                                    value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" autocomplete="off">
                                @error('tanggal_pinjam')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                                <input type="date" class="form-control @error('tanggal_kembali') is-invalid @enderror"
                                    id="tanggal_kembali" name="tanggal_kembali" required
                                    value="{{ old('tanggal_kembali') }}" autocomplete="off">
                                @error('tanggal_kembali')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="keperluan" class="form-label">Keperluan</label>
                                <textarea class="form-control @error('keperluan') is-invalid @enderror" id="keperluan" name="keperluan" rows="3"
                                    required autocomplete="off">{{ old('keperluan') }}</textarea>
                                @error('keperluan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Submit Peminjaman</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Daftar Peminjaman Section -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Daftar Peminjaman</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Peminjam</th>
                                        <th>Unit/Bagian</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($peminjaman->count() > 0)
                                        @foreach ($peminjaman as $pinjam)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $pinjam->user->name }}</td>
                                                <td>{{ ucfirst($pinjam->user->unit_bagian) }}</td>
                                                <td>{{ $pinjam->barang->nama_barang }}</td>
                                                <td>{{ $pinjam->jumlah_pinjam }}</td>
                                                <td>{{ date('d/m/Y', strtotime($pinjam->tanggal_pinjam)) }}</td>
                                                <td>{{ date('d/m/Y', strtotime($pinjam->tanggal_kembali)) }}</td>
                                                <td>
                                                    @if ($pinjam->status == 'dipinjam')
                                                        <span class="badge bg-warning">Dipinjam</span>
                                                    @elseif($pinjam->status == 'dikembalikan')
                                                        <span class="badge bg-success">Dikembalikan</span>
                                                    @else
                                                        <span class="badge bg-danger">Dibatalkan</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="/pinjam/{{ $pinjam->id }}"
                                                        class="badge bg-info text-decoration-none">
                                                        <i class="bi bi-eye"></i> Detail
                                                    </a>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Date validation
            document.addEventListener('DOMContentLoaded', function() {
                // Set minimum date for tanggal_pinjam to today
                const today = new Date().toISOString().split('T')[0];
                const tanggalPinjam = document.getElementById('tanggal_pinjam');
                const tanggalKembali = document.getElementById('tanggal_kembali');

                tanggalPinjam.min = today;
                tanggalPinjam.value = today;
                tanggalKembali.min = today;

                tanggalPinjam.addEventListener('change', function() {
                    tanggalKembali.min = this.value;
                    if (tanggalKembali.value < this.value) {
                        tanggalKembali.value = this.value;
                    }
                });
            });
        </script>
    @endpush

@endsection
