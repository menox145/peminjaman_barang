@extends('layouts.main')

@section('container')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Detail Barang</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th width="200">Kode Barang</th>
                                <td>{{ $barang->kode_barang }}</td>
                            </tr>
                            <tr>
                                <th>Nama Barang</th>
                                <td>{{ $barang->nama_barang }}</td>
                            </tr>
                            <tr>
                                <th>Merk</th>
                                <td>{{ $barang->merk }}</td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td>{{ $barang->type }}</td>
                            </tr>
                            <tr>
                                <th>Spesifikasi</th>
                                <td>{{ $barang->spesifikasi }}</td>
                            </tr>
                            <tr>
                                <th>Stok</th>
                                <td>{{ $barang->stok }} {{ $barang->satuan }}</td>
                            </tr>
                            <tr>
                                <th>Lokasi</th>
                                <td>{{ $barang->lokasi }}</td>
                            </tr>
                            <tr>
                                <th>Kondisi</th>
                                <td>
                                    @if($barang->kondisi == 'Baik')
                                        <span class="badge bg-success">{{ $barang->kondisi }}</span>
                                    @elseif($barang->kondisi == 'Rusak Ringan')
                                        <span class="badge bg-warning">{{ $barang->kondisi }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $barang->kondisi }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Keterangan</th>
                                <td>{{ $barang->keterangan ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="mt-3">
                        <a href="/dashboard" class="btn btn-secondary">Kembali</a>
                        <a href="/dashboard/{{ $barang->id }}/edit" class="btn btn-warning">Edit</a>
                        <form action="/dashboard/{{ $barang->id }}" method="post" class="d-inline">
                            @method('delete')
                            @csrf
                            <button class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data?')">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 