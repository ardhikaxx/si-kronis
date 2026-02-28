@extends('layouts.admin')

@section('title', 'Template Resep')

@section('content')
<div class="page-header animate-fade-in">
    <div><h1 class="page-title">Template Resep</h1><p class="page-subtitle">Kelola template resep</p></div>
    <a href="{{ route('admin.template-resep.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah</a>
</div>

<div class="section-card animate-fade-in">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr><th>No</th><th>Nama</th><th>Deskripsi</th><th>Obat</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse($templates as $template)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><span class="fw-bold">{{ $template->nama_template }}</span></td>
                    <td>{{ $template->deskripsi ?? '-' }}</td>
                    <td>{{ count($template->items ?? []) }} obat</td>
                    <td>
                        @if($template->is_active)
                            <span class="badge badge-confirmed">Aktif</span>
                        @else
                            <span class="badge badge-cancelled">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.template-resep.edit', $template->id) }}" class="action-btn action-btn-edit"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.template-resep.destroy', $template->id) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="submit" class="action-btn action-btn-delete" onclick="return confirm('Hapus?')"><i class="fas fa-trash"></i></button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6"><div class="empty-state"><i class="fas fa-file-prescription"></i><h5>Tidak Ada Data</h5></div></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($templates->hasPages())<div class="pagination-container">{{ $templates->links('pagination.bootstrap-5') }}</div>@endif
</div>
@endsection
