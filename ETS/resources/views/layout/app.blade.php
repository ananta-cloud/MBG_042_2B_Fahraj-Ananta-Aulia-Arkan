<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'Admin Dashboard') - Sistem Akademik</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
        <link rel="stylesheet" href="{{asset('css/template.css')}}" />
    </head>

    <body>

        {{-- Memanggil Sidebar --}}
        @include('partials.sidebar')

        {{-- KONTEN UTAMA --}}
        <div class="main-content">
            {{-- Memanggil Navbar Atas --}}
            @include('partials.navbar')

            {{-- KONTEN DINAMIS DARI SETIAP HALAMAN --}}
            <main class="mt-4">
                @yield('content')
            </main>

            {{-- Memanggil Footer --}}
            @include('partials.footer')
        </div>

       <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- BOOTSTRAP JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SWEETALERT2 (WAJIB UNTUK POP-UP) -->
        <script   script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- SCRIPT GENERAL ANDA DARI FILE EKSTERNAL -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/course_validation.js') }}"></script>
        <script src="{{ asset('js/student-crud_validation.js') }}"></script>
        <script src="{{ asset('js/course-list.js') }}"></script>
        @stack('scripts')
    </body>
</html>
