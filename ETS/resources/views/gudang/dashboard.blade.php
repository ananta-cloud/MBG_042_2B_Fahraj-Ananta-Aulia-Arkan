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
    <div class="row">
        <div class="col-lg">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body ">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h4 font-weight-bold text-primary text-uppercase mb-3">Total Bahan Baku</div>
                            <div class="h2 mb-0 font-weight-bold "></div>
                            <hr>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-4x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h4 font-weight-bold text-primary text-uppercase mb-3">Total Permintaan</div>
                            <div class="h2 mb-0 font-weight-bold "></div>
                            <hr>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-4x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
