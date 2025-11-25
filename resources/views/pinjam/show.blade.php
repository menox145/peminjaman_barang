@extends('layouts.main')

@section('container')
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Detail Peminjaman</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="200">Kode Barang</th>
                                    <td>{{ $pinjam->barang->kode_barang }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Barang</th>
                                    <td>{{ $pinjam->barang->nama_barang }}</td>
                                </tr>
                                <tr>
                                    <th>Peminjam</th>
                                    <td>{{ $pinjam->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Pinjam</th>
                                    <td>{{ $pinjam->jumlah_pinjam }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pinjam</th>
                                    <td>{{ date('d/m/Y', strtotime($pinjam->tanggal_pinjam)) }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Kembali</th>
                                    <td>{{ date('d/m/Y', strtotime($pinjam->tanggal_kembali)) }}</td>
                                </tr>
                                <tr>
                                    <th>Keperluan</th>
                                    <td>{{ $pinjam->keperluan }}</td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td>{{ $pinjam->keterangan ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($pinjam->status == 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($pinjam->status == 'approved')
                                            <span class="badge bg-success">Disetujui</span>
                                        @elseif($pinjam->status == 'rejected')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @else
                                            <span class="badge bg-info">Dikembalikan</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="mt-3">
                            <a href="/pinjam" class="btn btn-secondary">Kembali</a>

                            @if ($pinjam->status == 'pending')
                                @if (Auth::id() == $pinjam->user_id)
                                    <form action="/pinjam/{{ $pinjam->id }}" method="POST" class="d-inline">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Yakin ingin membatalkan peminjaman?')">
                                            Batalkan Peminjaman
                                        </button>
                                    </form>
                                @endif

                                {{-- Semua user bisa akses fitur ini --}}
                                @if (Auth::user()->is_admin)
                                    <form action="/pinjam/{{ $pinjam->id }}/approve" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success"
                                            onclick="return confirm('Setujui peminjaman ini?')">
                                            Setujui
                                        </button>
                                    </form>
                                    <form action="/pinjam/{{ $pinjam->id }}/reject" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Tolak peminjaman ini?')">
                                            Tolak
                                        </button>
                                    </form>
                                @endif
                            @endif

                            @if ($pinjam->status == 'approved')
                                <form action="/pinjam/{{ $pinjam->id }}/return" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-info"
                                        onclick="return confirm('Konfirmasi pengembalian barang?')">
                                        Konfirmasi Pengembalian
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
