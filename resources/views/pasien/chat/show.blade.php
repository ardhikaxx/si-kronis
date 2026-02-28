@extends('layouts.pasien')

@section('title', 'Chat dengan ' . $dokter->name)

@section('content')
<div class="sk-mobile-container">
    <div class="sk-header d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a href="{{ route('pasien.chat.index') }}" class="me-3 text-white">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="avatar avatar-white me-2" style="background: white; color: var(--sk-primary);">
                {{ substr($dokter->name, 0, 1) }}
            </div>
            <div>
                <h6 class="mb-0 text-white fw-bold">{{ $dokter->name }}</h6>
                <small class="text-white-50">{{ $dokter->doctorProfile->spesialisasi ?? 'Dokter' }}</small>
            </div>
        </div>
    </div>

    <div class="sk-content chat-messages" style="padding-bottom: 80px; padding-top: 80px;">
        @forelse($messages as $message)
        <div class="message mb-3 {{ $message->sender_id === auth()->id() ? 'text-end' : 'text-start' }}">
            <div class="d-inline-block p-3 rounded {{ $message->sender_id === auth()->id() ? 'bg-primary text-white' : 'bg-light' }}" style="max-width: 80%;">
                <p class="mb-0">{{ $message->message }}</p>
                <small class="{{ $message->sender_id === auth()->id() ? 'text-white-50' : 'text-muted' }}">
                    {{ $message->created_at->format('H:i') }}
                </small>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <i class="fas fa-comments text-muted" style="font-size: 48px;"></i>
            <p class="text-muted mt-3">Belum ada pesan</p>
            <small class="text-muted">Kirim pesan pertama Anda</small>
        </div>
        @endforelse
    </div>

    <div class="chat-input bg-white p-3 border-top" style="position: fixed; bottom: 60px; left: 0; right: 0;">
        <form action="{{ route('pasien.chat.store', $dokter->id) }}" method="POST" class="d-flex gap-2">
            @csrf
            <input type="text" name="message" class="form-control" placeholder="Ketik pesan..." required>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>
@endsection
