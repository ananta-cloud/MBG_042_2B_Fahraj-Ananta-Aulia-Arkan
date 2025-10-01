@extends('layout.app')

@section('title', 'Kelola Bahan Baku')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0 text-gray-800">Kelola Bahan Baku</h1>
        <a href="{{ route('gudang.bahan_baku.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm"></i> Tambah Baru
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Bahan Baku</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Satuan</th>
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Kadaluarsa</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bahan_baku as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ $item->satuan }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_masuk)->isoFormat('D MMM YYYY') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_kadaluarsa)->isoFormat('D MMM YYYY') }}</td>
                            <td>
                                @if($item->status == 'tersedia')
                                    <span class="badge bg-success">{{ ucfirst($item->status) }}</span>
                                @elseif($item->status == 'segera kadaluarsa')
                                    <span class="badge bg-warning text-dark">{{ ucfirst($item->status) }}</span>
                                @else
                                    <span class="badge bg-danger">{{ ucfirst($item->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <form onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" action="{{ route('gudang.bahan_baku.destroy', $item->id) }}" method="POST">
                                    <a href="{{ route('gudang.bahan_baku.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Belum ada data bahan baku.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- Link Paginasi --}}
                <div class="d-flex justify-content-center">
                    {{ $bahan_baku->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
