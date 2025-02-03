@extends('layouts.main')

@section('container')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Edit Barang</h5>
                </div>
                <div class="card-body">
                    <form action="/dashboard/{{ $barang->id }}" method="POST">
                        @method('put')
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kode_barang">Kode Barang</label>
                                    <input type="text" class="form-control @error('kode_barang') is-invalid @enderror" 
                                        id="kode_barang" name="kode_barang" required value="{{ old('kode_barang', $barang->kode_barang) }}">
                                    @error('kode_barang')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_barang">Nama Barang</label>
                                    <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" 
                                        id="nama_barang" name="nama_barang" required value="{{ old('nama_barang', $barang->nama_barang) }}">
                                    @error('nama_barang')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="merk">Merk</label>
                                    <input type="text" class="form-control @error('merk') is-invalid @enderror" 
                                        id="merk" name="merk" required value="{{ old('merk', $barang->merk) }}">
                                    @error('merk')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <input type="text" class="form-control @error('type') is-invalid @enderror" 
                                        id="type" name="type" required value="{{ old('type', $barang->type) }}">
                                    @error('type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="spesifikasi">Spesifikasi</label>
                                    <textarea class="form-control @error('spesifikasi') is-invalid @enderror" 
                                        id="spesifikasi" name="spesifikasi" rows="3" required>{{ old('spesifikasi', $barang->spesifikasi) }}</textarea>
                                    @error('spesifikasi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="stok">Stok</label>
                                    <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                                        id="stok" name="stok" required value="{{ old('stok', $barang->stok) }}">
                                    @error('stok')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="satuan">Satuan</label>
                                    <input type="text" class="form-control @error('satuan') is-invalid @enderror" 
                                        id="satuan" name="satuan" required value="{{ old('satuan', $barang->satuan) }}">
                                    @error('satuan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="kondisi">Kondisi</label>
                                    <select class="form-control @error('kondisi') is-invalid @enderror" 
                                        id="kondisi" name="kondisi" required>
                                        <option value="">Pilih Kondisi</option>
                                        <option value="Baik" {{ (old('kondisi', $barang->kondisi) == 'Baik') ? 'selected' : '' }}>Baik</option>
                                        <option value="Rusak Ringan" {{ (old('kondisi', $barang->kondisi) == 'Rusak Ringan') ? 'selected' : '' }}>Rusak Ringan</option>
                                        <option value="Rusak Berat" {{ (old('kondisi', $barang->kondisi) == 'Rusak Berat') ? 'selected' : '' }}>Rusak Berat</option>
                                    </select>
                                    @error('kondisi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="lokasi">Lokasi</label>
                                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                                        id="lokasi" name="lokasi" required value="{{ old('lokasi', $barang->lokasi) }}">
                                    @error('lokasi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <input type="text" class="form-control @error('keterangan') is-invalid @enderror" 
                                        id="keterangan" name="keterangan" value="{{ old('keterangan', $barang->keterangan) }}">
                                    @error('keterangan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="/dashboard" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 