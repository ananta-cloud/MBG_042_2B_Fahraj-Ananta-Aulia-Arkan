@extends('layout.app')

@section('title', 'Kelola Request Bahan Baku')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0 text-gray-800">Kelola Request</h1>
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
            <h6 class="m-0 font-weight-bold text-primary">Daftar Request</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Pemohon</th>
                            <th>Tanggal Masak</th>
                            <th>Menu Makan</th>
                            <th>Jumlah Porsi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($permintaan as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->pemohon->name ?? 'User Dihapus' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_masak)->isoFormat('D MMM YYYY') }}</td>
                            <td>{{ $item->menu_makan }}</td>
                            <td>{{ $item->jumlah_porsi }}</td>
                            <td>
                                <span class="badge bg-warning text-dark">{{ ucfirst($item->status) }}</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm btn-detail"
                                        data-id="{{ $item->id }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailModal">
                                    <i class="fas fa-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada permintaan baru.</td>
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

<!-- Modal untuk Detail Permintaan -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Permintaan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="loading" class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="modalContent" style="display: none;">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th style="width: 150px;">Menu</th>
                            <td id="modalMenuMakan"></td>
                        </tr>
                        <tr>
                            <th>Pemohon</th>
                            <td id="modalPemohon"></td>
                        </tr>
                        <tr>
                            <th>Tgl Masak</th>
                            <td id="modalTglMasak"></td>
                        </tr>
                    </table>
                    <hr>
                    <h6>Bahan yang Diminta:</h6>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Bahan</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                            </tr>
                        </thead>
                        <tbody id="modalBahanTableBody"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <div class="d-flex">
                    <form id="formReject" method="POST" class="me-2" onsubmit="return confirm('Anda yakin ingin menolak permintaan ini?');">
                        @csrf
                        <button type="submit" class="btn btn-danger"><i class="fas fa-times"></i> Tolak</button>
                    </form>
                    <form id="formApprove" method="POST" onsubmit="return confirm('Anda yakin ingin menyetujui permintaan ini? Stok akan dikurangi.');">
                        @csrf
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Setujui</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const detailModal = document.getElementById('detailModal');

    if (detailModal) {
        const modalContent = document.getElementById('modalContent');
        const loadingIndicator = document.getElementById('loading');
        const modalBahanTableBody = document.getElementById('modalBahanTableBody');

        detailModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const permintaanId = button.getAttribute('data-id');

            loadingIndicator.style.display = 'block';
            modalContent.style.display = 'none';
            modalBahanTableBody.innerHTML = '';

            const url = `{{ route('gudang.kelola_request.show', ['kelola_request' => ':id']) }}`.replace(':id', permintaanId);

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    document.getElementById('modalMenuMakan').textContent = data.menu_makan;
                    document.getElementById('modalPemohon').textContent = data.pemohon ? data.pemohon.name : '[User Dihapus]';

                    const tglMasak = new Date(data.tgl_masak);
                    const options = { day: 'numeric', month: 'long', year: 'numeric' };
                    document.getElementById('modalTglMasak').textContent = tglMasak.toLocaleDateString('id-ID', options);

                    // --- PERBAIKAN UTAMA ADA DI SINI ---
                    data.detail.forEach((item, index) => {
                        // Cek apakah item.bahan_baku ada (tidak null) sebelum mengakses propertinya
                        const namaBahan = item.bahan_baku ? item.bahan_baku.nama : '<span class="text-danger">[Bahan Dihapus]</span>';
                        const satuanBahan = item.bahan_baku ? item.bahan_baku.satuan : '-';

                        const row = `<tr>
                                        <td>${index + 1}</td>
                                        <td>${namaBahan}</td>
                                        <td>${item.jumlah_diminta}</td>
                                        <td>${satuanBahan}</td>
                                     </tr>`;
                        // Gunakan innerHTML agar tag <span> bisa dirender
                        modalBahanTableBody.insertAdjacentHTML('beforeend', row);
                    });

                    const approveUrl = `{{ route('gudang.kelola_request.approve', ['kelola_request' => ':id']) }}`.replace(':id', data.id);
                    const rejectUrl = `{{ route('gudang.kelola_request.reject', ['kelola_request' => ':id']) }}`.replace(':id', data.id);

                    document.getElementById('formApprove').action = approveUrl;
                    document.getElementById('formReject').action = rejectUrl;

                    loadingIndicator.style.display = 'none';
                    modalContent.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error fetching detail:', error);
                    loadingIndicator.innerHTML = '<p class="text-danger">Gagal memuat data. Periksa konsol browser (F12) untuk detail error.</p>';
                });
        });
    }
});
</script>
@endpush

