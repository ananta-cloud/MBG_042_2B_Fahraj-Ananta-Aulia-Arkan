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
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                <table class="table table-bordered table-striped table-hover">
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
                            {{-- Perbaikan untuk penomoran paginasi --}}
                            <td>{{ $loop->iteration + $bahan_baku->firstItem() - 1 }}</td>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ $item->satuan }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_masuk)->isoFormat('D MMM YYYY') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_kadaluarsa)->isoFormat('D MMM YYYY') }}</td>
                            <td>
                                @if ($item->status == 'tersedia')
                                    <span class="badge bg-success text-white">{{ ucfirst($item->status) }}</span>
                                @elseif($item->status == 'segera_kadaluarsa')
                                    <span class="badge bg-warning text-dark">{{ ucfirst(str_replace('_', ' ', $item->status)) }}</span>
                                @elseif($item->status == 'kadaluarsa')
                                    <span class="badge bg-danger text-white">{{ ucfirst($item->status) }}</span>
                                @else
                                    <span class="badge bg-secondary text-white">{{ ucfirst($item->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('gudang.bahan_baku.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                {{-- Tombol ini sekarang hanya memicu modal dan membawa data --}}
                                <button type="button" class="btn btn-danger btn-sm btn-hapus"
                                    data-id="{{ $item->id }}"
                                    data-nama="{{ $item->nama }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalKonfirmasiHapus">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Belum ada data bahan baku.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $bahan_baku->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalKonfirmasiHapus" tabindex="-1" aria-labelledby="modalKonfirmasiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalKonfirmasiLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- Form ini action-nya akan diisi oleh JavaScript --}}
            <form id="formHapus" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus bahan baku berikut?</p>
                    <p class="fw-bold" id="namaBahanHapus"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalKonfirmasiHapus = document.getElementById('modalKonfirmasiHapus');

    // Event listener ini akan berjalan setiap kali modal akan ditampilkan
    modalKonfirmasiHapus.addEventListener('show.bs.modal', function (event) {
        // Dapatkan tombol yang diklik untuk membuka modal
        const button = event.relatedTarget;

        // Ambil data dari atribut 'data-*' pada tombol yang diklik
        const bahanId = button.getAttribute('data-id');
        const bahanNama = button.getAttribute('data-nama');

        // Temukan form hapus di dalam modal
        const formHapus = document.getElementById('formHapus');

        let actionUrl = "{{ route('gudang.bahan_baku.destroy', ':id') }}";
        actionUrl = actionUrl.replace(':id', bahanId);

        // Setel atribut action pada form
        formHapus.setAttribute('action', actionUrl);

        // Tampilkan nama bahan baku di body modal untuk konfirmasi
        const namaBahanElement = document.getElementById('namaBahanHapus');
        namaBahanElement.textContent = `Nama: ${bahanNama}`;
    });
});
</script>
@endpush
