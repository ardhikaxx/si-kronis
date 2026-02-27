@extends('layouts.admin')

@section('title', 'Chat dengan Pasien')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h4 class="mb-3">Chat dengan Pasien</h4>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($conversations->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-comments text-muted" style="font-size: 48px;"></i>
            <p class="text-muted mt-3">Belum ada percakapan</p>
            <p class="text-muted">Pasien akan memulai percakapan dengan Anda</p>
        </div>
        @else
        <div class="list-group list-group-flush">
            @foreach($conversations as $conversation)
            <a href="{{ route('dokter.chat.show', $conversation['user']->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-circle bg-primary text-white me-3">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">{{ $conversation['user']->name }}</h6>
                        <small class="text-muted">{{ Str::limit($conversation['last_message'], 40) }}</small>
                    </div>
                </div>
                <div class="text-end">
                    <small class="text-muted">{{ $conversation['last_time']->diffForHumans() }}</small>
                    @if($conversation['unread'] > 0)
                    <br><span class="badge bg-primary rounded-pill">{{ $conversation['unread'] }}</span>
                    @endif
                </div>
            </a>
            @endforeach
        </div>
        @endif
    </div>
</div>
@endsection
