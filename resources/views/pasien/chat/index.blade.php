@extends('layouts.pasien')

@section('title', 'Chat dengan Dokter')

@section('content')
<div class="sk-mobile-container">
    <div class="sk-header">
        <h5 class="mb-0">Chat dengan Dokter</h5>
    </div>

    <div class="sk-content">
        @if($conversations->isEmpty() && $doctors->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-comments text-muted" style="font-size: 48px;"></i>
            <p class="text-muted mt-3">Tidak ada dokter tersedia</p>
            <a href="{{ route('pasien.konsultasi.index') }}" class="btn btn-primary btn-sm">
                Mulai Konsultasi
            </a>
        </div>
        @else
        <div class="mb-4">
            <h6 class="fw-bold mb-3">Pilih Dokter</h6>
            <div class="list-group">
                @foreach($doctors as $doctor)
                <a href="{{ route('pasien.chat.show', $doctor->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="sk-avatar me-3">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $doctor->name }}</h6>
                            <small class="text-muted">{{ $doctor->doctorProfile->spesialisasi ?? 'Dokter Umum' }}</small>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-muted"></i>
                </a>
                @endforeach
            </div>
        </div>

        @if($conversations->isNotEmpty())
        <div class="mb-4">
            <h6 class="fw-bold mb-3">Percakapan</h6>
            <div class="list-group">
                @foreach($conversations as $conversation)
                <a href="{{ route('pasien.chat.show', $conversation['user']->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="sk-avatar me-3">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $conversation['user']->name }}</h6>
                            <small class="text-muted">{{ Str::limit($conversation['last_message'], 30) }}</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <small class="text-muted">{{ $conversation['last_time']->diffForHumans() }}</small>
                        @if($conversation['unread'] > 0)
                        <span class="badge bg-primary rounded-pill">{{ $conversation['unread'] }}</span>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
        @endif
    </div>
</div>
@endsection
