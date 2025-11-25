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

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Master Tindakan</h5>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahTindakan">
                    <i class="bi bi-plus-circle"></i> Tambah Tindakan
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Tindakan</th>
                                <th>Nama Tindakan</th>
                                <th>Harga</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tindakan as $t)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $t->kode_tindakan }}</td>
                                    <td>{{ $t->nama_tindakan }}</td>
                                    <td>Rp {{ number_format($t->harga, 0, ',', '.') }}</td>
                                    <td>{{ $t->keterangan ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('master.tindakan.show', $t->id) }}"
                                            class="badge bg-info text-decoration-none">
                                            <i class="bi bi-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('master.tindakan.edit', $t->id) }}"
                                            class="badge bg-warning text-decoration-none">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('master.tindakan.destroy', $t->id) }}" method="POST"
                                            class="d-inline">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="badge bg-danger border-0"
                                                onclick="return confirm('Yakin ingin menghapus tindakan ini?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data tindakan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Tindakan -->
    <div class="modal fade" id="modalTambahTindakan" tabindex="-1" aria-labelledby="modalTambahTindakanLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahTindakanLabel">Tambah Tindakan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('master.tindakan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="kode_tindakan" class="form-label">Kode Tindakan</label>
                            <input type="text" class="form-control @error('kode_tindakan') is-invalid @enderror"
                                id="kode_tindakan" name="kode_tindakan" value="{{ old('kode_tindakan') }}" required>
                            @error('kode_tindakan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="jenis_tindakan" class="form-label">Jenis Tindakan</label>
                            <input type="text" class="form-control @error('jenis_tindakan') is-invalid @enderror"
                                id="jenis_tindakan" name="jenis_tindakan" value="{{ old('jenis_tindakan') }}" required>
                            @error('jenis_tindakan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="group_tindakan">Group Tindakan</label>
                                <select class="form-control @error('group_tindakan') is-invalid @enderror"
                                    id="group_tindakan" name="group_tindakan" required>
                                    <option value="">Pilih Group </option>
                                    <option value="Paket" {{ old('group_tindakan') == 'Paket' ? 'selected' : '' }}>
                                        Paket</option>
                                    <option value="non_paket" {{ old('group_tindakan') == 'non_paket' ? 'selected' : '' }}>
                                        Non Paket</option>

                                </select>
                                @error('group_tindakan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nama_tindakan" class="form-label">Nama Tindakan</label>
                            <input type="text" class="form-control @error('nama_tindakan') is-invalid @enderror"
                                id="nama_tindakan" name="nama_tindakan" value="{{ old('nama_tindakan') }}" required>
                            @error('nama_tindakan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                    id="harga" name="harga" value="{{ old('harga') }}" required min="0">
                            </div>
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan"
                                rows="3">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
