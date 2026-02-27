@extends('layouts.admin')

@section('title', 'Template Resep')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title">Template Resep</h1>
    <a href="{{ route('admin.template-resep.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Tambah Template
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Template</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Obat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($templates as $template)
                    <tr>
                        <td>{{ $loop->iteration + ($templates->currentPage() - 1) * $templates->perPage() }}</td>
                        <td>{{ $template->nama_template }}</td>
                        <td>{{ $template->deskripsi ?? '-' }}</td>
                        <td>{{ count($template->items ?? []) }} obat</td>
                        <td>
                            @if($template->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.template-resep.edit', $template->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.template-resep.destroy', $template->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus template ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada template resep</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            <div class="pagination-info">
                Menampilkan {{ $templates->firstItem() ?? 0 }} - {{ $templates->lastItem() ?? 0 }} dari {{ $templates->total() }} data
            </div>
            {{ $templates->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
