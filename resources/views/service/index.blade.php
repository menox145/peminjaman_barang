@extends('layouts.master')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-3">
            <h3>Data Service Printer</h3>
            <a href="{{ route('service.create') }}" class="btn btn-primary">+ Tambah Service</a>
        </div>

        <div class="card p-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Pelanggan</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Keluhan</th>
                        <th>Status</th>
                        <th>Tanggal Masuk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $srv)
                        <tr>
                            <td>{{ $srv->customer_name }}</td>
                            <td>{{ $srv->brand }}</td>
                            <td>{{ $srv->model }}</td>
                            <td>{{ $srv->keluhan }}</td>
                            <td>
                                <span class="badge bg-info">{{ $srv->status }}</span>
                            </td>
                            <td>{{ $srv->tanggal_masuk }}</td>
                            <td>
                                <a href="{{ route('service.show', $srv->id) }}" class="btn btn-sm btn-info">Detail</a>
                                <a href="{{ route('service.edit', $srv->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('service.destroy', $srv->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Hapus data?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
