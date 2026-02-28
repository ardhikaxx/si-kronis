@extends('layouts.pasien')

@section('title', 'Chat dengan Dokter')

@section('content')
<div class="sk-mobile-container">
    <div class="sk-header">
        <h5 class="mb-0">Chat dengan Dokter</h5>
    </div>

    <div class="sk-content">
        @if($doctors->isEmpty() && $conversations->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-comments text-muted" style="font-size: 64px;"></i>
            <h6 class="mt-3">Tidak Ada Dokter</h6>
            <p class="text-muted">Tidak ada dokter tersedia saat ini</p>
            <a href="{{ route('pasien.konsultasi.index') }}" class="btn btn-primary btn-sm">
                Konsultasi
            </a>
        </div>
        @else
        <!-- List Doctors -->
        @if($doctors->isNotEmpty())
        <div class="mb-4">
            <h6 class="fw-bold mb-3 px-3">
                <i class="fas fa-user-md me-2 text-primary"></i>Pilih Dokter
            </h6>
            <div class="list-group">
                @foreach($doctors as $doctor)
                <a href="{{ route('pasien.chat.show', $doctor->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-primary me-3">
                            {{ substr($doctor->name, 0, 1) }}
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $doctor->name }}</h6>
                            <small class="text-muted">{{ $doctor->doctorProfile->spesialisasi ?? 'Dokter Umum' }}</small>
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-muted"></i>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        @if($conversations->isNotEmpty())
        <div class="mb-4 px-3">
            <h6 class="fw-bold mb-3">
                <i class="fas fa-comments me-2 text-success"></i>Percakapan
            </h6>
            <div class="list-group">
                @foreach($conversations as $conversation)
                <a href="{{ route('pasien.chat.show', $conversation['user']->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-success me-3">
                            {{ substr($conversation['user']->name, 0, 1) }}
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $conversation['user']->name }}</h6>
                            <small class="text-muted">{{ Str::limit($conversation['last_message'], 30) }}</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <small class="text-muted d-block">{{ $conversation['last_time']->diffForHumans() }}</small>
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
