@extends('layouts.admin')

@section('title', 'Chat - ' . $pasien->name)

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <a href="{{ route('dokter.chat.index') }}" class="me-3 text-dark">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">{{ $pasien->name }}</h5>
                <small class="text-muted">Pasien</small>
            </div>
            <div class="card-body chat-messages" style="height: 400px; overflow-y: auto;">
                @forelse($messages as $message)
                <div class="mb-3 {{ $message->sender_id == auth()->id() ? 'text-end' : '' }}">
                    <div class="d-inline-block p-3 rounded {{ $message->sender_id == auth()->id() ? 'bg-primary text-white' : 'bg-light' }}" style="max-width: 75%;">
                        <p class="mb-0">{{ $message->message }}</p>
                        <small class="{{ $message->sender_id == auth()->id() ? 'text-white-50' : 'text-muted' }}">
                            {{ $message->created_at->format('H:i') }}
                        </small>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-5">
                    <p>Belum ada pesan</p>
                </div>
                @endforelse
            </div>
            <div class="card-footer bg-white">
                <form action="{{ route('dokter.chat.store', $pasien->id) }}" method="POST" class="d-flex gap-2">
                    @csrf
                    <input type="text" name="message" class="form-control" placeholder="Tulis pesan..." required>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
