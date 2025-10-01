<nav class="top-nav d-flex justify-content-end align-items-center">
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-dark text-decoration-none" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user-circle fa-2x me-2"></i>
            {{-- Mengambil nama lengkap dari user yang sedang login --}}
            <strong>{{ Auth::user()->name ?? 'Nama Pengguna' }}</strong>
        </a>
    </div>
</nav>
