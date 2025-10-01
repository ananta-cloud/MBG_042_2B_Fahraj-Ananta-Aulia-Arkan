<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="stylesheet" href="{{asset('css/login.css')}}"/>

</head>
<body>
    <div class="login-card">
        <h2 class="login-title">Halaman Login</h2>

        {{-- Menampilkan pesan login gagal dari AuthController --}}
        @if (session('fail'))
            <div class="alert-danger">
                {{ session('fail') }}
            </div>
        @endif

        <!-- Form Login -->
        {{-- Menggunakan helper route() untuk action form --}}
        <form action="{{ route('login') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>

                {{-- Menampilkan error validasi spesifik untuk 'username' --}}
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>

                {{-- Menampilkan error validasi spesifik untuk 'password' --}}
                @error('password')
                     <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-submit">Login</button>

        </form>
    </div>

</body>
</html>
