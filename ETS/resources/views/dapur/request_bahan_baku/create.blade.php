@extends('layout.app')

@section('title', 'Buat Permintaan Bahan Baku')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Formulir Permintaan Bahan Baku</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detail Permintaan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('dapur.request_bahan_baku.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="tgl_masak" class="form-label">Tanggal Rencana Masak</label>
                            <input type="date" class="form-control @error('tgl_masak') is-invalid @enderror" id="tgl_masak" name="tgl_masak" value="{{ old('tgl_masak', date('Y-m-d')) }}">
                            @error('tgl_masak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="menu_makan" class="form-label">Nama Menu</label>
                            <input type="text" class="form-control @error('menu_makan') is-invalid @enderror" id="menu_makan" name="menu_makan" value="{{ old('menu_makan') }}" placeholder="Contoh: Nasi Goreng Spesial">
                            @error('menu_makan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="jumlah_porsi" class="form-label">Jumlah Porsi</label>
                            <input type="number" class="form-control @error('jumlah_porsi') is-invalid @enderror" id="jumlah_porsi" name="jumlah_porsi" value="{{ old('jumlah_porsi') }}" min="1">
                            @error('jumlah_porsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>

                <h6 class="font-weight-bold">Bahan Baku yang Dibutuhkan</h6>
                @error('bahan_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div id="bahan-container">
                    {{-- Baris bahan baku akan ditambahkan di sini oleh JavaScript --}}
                </div>

                <button type="button" id="add-bahan-btn" class="btn btn-success btn-sm mt-2">
                    <i class="fas fa-plus"></i> Tambah Bahan
                </button>

                <hr>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('dapur.request_bahan_baku.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Kirim Permintaan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Template ini disembunyikan dan akan digunakan oleh JavaScript untuk membuat baris baru --}}
<template id="bahan-template">
    <div class="row align-items-center mb-2 bahan-row">
        <div class="col-md-6">
            <select class="form-select" name="bahan_id[]" required>
                <option value="" disabled selected>-- Pilih Bahan Baku --</option>
                @foreach ($bahan_baku as $bahan)
                    <option value="{{ $bahan->id }}">{{ $bahan->nama }} (Stok: {{ $bahan->jumlah }} {{ $bahan->satuan }})</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <input type="number" class="form-control" name="jumlah_diminta[]" placeholder="Jumlah" min="1" required>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm remove-bahan-btn w-100">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </div>
    </div>
</template>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addBahanBtn = document.getElementById('add-bahan-btn');
    const bahanContainer = document.getElementById('bahan-container');
    const bahanTemplate = document.getElementById('bahan-template');

    // Fungsi untuk menambah baris bahan baru
    function addBahanRow() {
        // Meng-clone konten dari template
        const newRow = bahanTemplate.content.cloneNode(true);
        bahanContainer.appendChild(newRow);
    }

    // Tambah baris pertama secara otomatis saat halaman dimuat
    addBahanRow();

    // Event listener untuk tombol 'Tambah Bahan'
    addBahanBtn.addEventListener('click', addBahanRow);

    // Event listener untuk tombol 'Hapus' pada setiap baris
    // Menggunakan event delegation agar tombol hapus di baris baru juga berfungsi
    bahanContainer.addEventListener('click', function(e) {
        // Cek apakah yang diklik adalah tombol hapus, dan pastikan minimal ada 1 baris tersisa
        if (e.target && e.target.classList.contains('remove-bahan-btn') && bahanContainer.children.length > 1) {
            // Hapus elemen .bahan-row terdekat dari tombol yang diklik
            e.target.closest('.bahan-row').remove();
        }
    });
});
</script>
@endpush

