@extends('layouts.admin')
@section('title', 'Edit User')

@section('content')
<div class="page-header animate-fade-in">
    <div>
        <h1 class="page-title">Edit User</h1>
        <p class="page-subtitle">Ubah data user</p>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="section-card animate-fade-in">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">No. Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ $user->is_active ? 'checked' : '' }}>
                        <label class="form-check-label">Status Aktif</label>
                    </div>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
