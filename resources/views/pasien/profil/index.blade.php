@extends('layouts.pasien')

@section('title', 'Profil Saya')

@section('content')
<div class="p-3">
    <h5 class="fw-bold mb-4">Profil Saya</h5>

    <form action="{{ route('pasien.profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card sk-card mb-3">
            <div class="sk-card-header">Informasi Akun</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                </div>
            </div>
        </div>

        <div class="card sk-card mb-3">
            <div class="sk-card-header">Data Pribadi</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">NIK</label>
                    <input type="text" name="nik" class="form-control" value="{{ $user->profile->nik ?? '' }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ $user->profile->tanggal_lahir ?? '' }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ ($user->profile->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ ($user->profile->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Golongan Darah</label>
                    <select name="golongan_darah" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="A" {{ ($user->profile->golongan_darah ?? '') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ ($user->profile->golongan_darah ?? '') == 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ ($user->profile->golongan_darah ?? '') == 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ ($user->profile->golongan_darah ?? '') == 'O' ? 'selected' : '' }}>O</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2">{{ $user->profile->alamat ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <div class="card sk-card mb-3">
            <div class="sk-card-header">Kondisi Kronis</div>
            <div class="card-body">
                @foreach($chronicCategories as $category)
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="chronic_conditions[]" value="{{ $category->id }}" 
                           id="chronic{{ $category->id }}"
                           {{ $user->chronicConditions->pluck('chronic_category_id')->contains($category->id) ? 'checked' : '' }}>
                    <label class="form-check-label" for="chronic{{ $category->id }}">
                        <i class="fas {{ $category->icon }}" style="color: {{ $category->warna }}"></i>
                        {{ $category->nama }}
                    </label>
                </div>
                @endforeach
            </div>
        </div>

        <div class="card sk-card mb-3">
            <div class="sk-card-header">Ubah Password</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <div class="password-input-wrapper">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah">
                        <button type="button" class="password-toggle-btn" onclick="togglePassword('password')">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <div class="password-input-wrapper">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        <button type="button" class="password-toggle-btn" onclick="togglePassword('password_confirmation')">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-3">
            <i class="fas fa-save me-2"></i>Simpan Perubahan
        </button>
    </form>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-outline-danger w-100">
            <i class="fas fa-sign-out-alt me-2"></i>Logout
        </button>
    </form>
</div>
@endsection
