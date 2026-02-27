@extends('layouts.auth')
@section('title', 'Daftar')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <i class="fa-solid fa-user-plus auth-logo"></i>
        <h4 class="mb-0 fw-bold">Daftar Akun</h4>
        <small>Mulai konsultasi kesehatan Anda</small>
    </div>
    
    <div class="auth-body">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <ul class="mb-0 small ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="name" class="form-label text-secondary fw-semibold">Nama Lengkap</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="John Doe">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label text-secondary fw-semibold">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com">
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label text-secondary fw-semibold">Password</label>
                <div class="password-input-wrapper">
                    <input type="password" class="form-control" id="password" name="password" required placeholder="••••••••">
                    <button type="button" class="password-toggle-btn" onclick="togglePassword('password')">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
                <small class="text-muted" style="font-size: 11px">Min. 8 karakter</small>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label text-secondary fw-semibold">Konfirmasi Password</label>
                <div class="password-input-wrapper">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="••••••••">
                    <button type="button" class="password-toggle-btn" onclick="togglePassword('password_confirmation')">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                Daftar Sekarang
            </button>
        </form>

        <div class="auth-footer">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
        </div>
    </div>
</div>
@endsection
