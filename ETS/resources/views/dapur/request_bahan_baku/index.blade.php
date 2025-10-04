@extends('layout.app')

@section('title', 'Riwayat Permintaan Saya')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0 text-gray-800">Riwayat Permintaan Bahan Baku</h1>
        <a href="{{ route('dapur.request_bahan_baku.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm"></i> Buat Permintaan Baru
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Permintaan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Masak</th>
                            <th>Menu</th>
                            <th>Jumlah Porsi</th>
                            <th>Status</th>
                            <th>Tanggal Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($permintaan as $item)
                        <tr>
                            <td>{{ $loop->iteration + $permintaan->firstItem() - 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_masak)->isoFormat('D MMM YYYY') }}</td>
                            <td>{{ $item->menu_makan }}</td>
                            <td>{{ $item->jumlah_porsi }}</td>
                            <td>
                                @if ($item->status == 'menunggu')
                                    <span class="badge bg-warning text-dark">{{ ucfirst($item->status) }}</span>
                                @elseif ($item->status == 'disetujui')
                                    <span class="badge bg-success">{{ ucfirst($item->status) }}</span>
                                @elseif ($item->status == 'ditolak')
                                    <span class="badge bg-danger">{{ ucfirst($item->status) }}</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('D MMM YYYY, HH:mm') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Anda belum pernah membuat permintaan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $permintaan->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
