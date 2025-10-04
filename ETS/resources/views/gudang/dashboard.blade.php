@extends('layout.app')

{{-- Mengatur Judul Halaman --}}
@section('title', 'Dashboard')

{{-- Mengisi Konten Halaman --}}
@section('content')
<div class="container-fluid">
    {{-- Judul Halaman Konten --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <div class="card shadow" id="hilang">
        <div class="card-header">
            Pemberitahuan Penting
        </div>
        <div class="card-body">
            Selamat datang di panel admin Sistem Permintaan Bahan Baku MBG.
        </div>
    </div>
    <br>
    <div class="row mt-4">
    <div class="col-lg">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h4 font-weight-bold text-danger text-uppercase mb-3">Kadaluarsa</div>
                        <div class="h2 mb-0 font-weight-bold">{{ $total_kadaluarsa }}</div>
                        <hr>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-triangle fa-4x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h4 font-weight-bold text-warning text-uppercase mb-3">Segera Kadaluarsa</div>
                        <div class="h2 mb-0 font-weight-bold">{{ $total_segera_kadaluarsa }}</div>
                        <hr>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hourglass-half fa-4x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h4 font-weight-bold text-dark text-uppercase mb-3">Habis</div>
                        <div class="h2 mb-0 font-weight-bold">{{ $total_habis }}</div>
                        <hr>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-ban fa-4x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h4 font-weight-bold text-dark text-uppercase mb-3">Total Permintaan</div>
                        <div class="h2 mb-0 font-weight-bold">{{ $total_permintaan }}</div>
                        <hr>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-ban fa-4x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
@endsection
