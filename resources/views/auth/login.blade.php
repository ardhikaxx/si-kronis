@extends('layouts.auth')
@section('title', 'Masuk')

@section('content')
<div class="auth-card">
    <div class="auth-header">
        <i class="fa-solid fa-hospital-user auth-logo"></i>
        <h4 class="mb-0 fw-bold">SI-KRONIS</h4>
        <small>Layanan Konsultasi Penyakit Kronis</small>
    </div>
    
    <div class="auth-body">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <small>{{ $errors->first() }}</small>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label text-secondary fw-semibold">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
            </div>
            
            <div class="mb-4">
                <label for="password" class="form-label text-secondary fw-semibold">Password</label>
                <input type="password" class="form-control" id="password" name="password" required placeholder="••••••••">
            </div>

            <button type="submit" class="btn btn-primary">
                Masuk
            </button>
        </form>

        <div class="auth-footer">
            Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
        </div>
    </div>
</div>
@endsection
