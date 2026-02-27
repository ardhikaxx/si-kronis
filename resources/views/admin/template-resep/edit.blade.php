@extends('layouts.admin')

@section('title', 'Edit Template Resep')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h4 class="mb-3">Edit Template Resep</h4>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.template-resep.update', $template->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Template <span class="text-danger">*</span></label>
                        <input type="text" name="nama_template" class="form-control @error('nama_template') is-invalid @enderror" value="{{ old('nama_template', $template->nama_template) }}" required>
                        @error('nama_template')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="2">{{ old('deskripsi', $template->deskripsi) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1" {{ $template->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Aktif</label>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h6 class="mb-3">Obat-obatan</h6>

                    <div id="medicine-items">
                        @foreach($template->items as $index => $item)
                        <div class="medicine-item mb-3 p-3 border rounded">
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Nama Obat</label>
                                    <input type="text" name="items[{{ $index }}][nama_obat]" class="form-control" value="{{ $item['nama_obat'] }}" required>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <label class="form-label">Dosis</label>
                                    <input type="text" name="items[{{ $index }}][dosis]" class="form-control" value="{{ $item['dosis'] }}" required>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <label class="form-label">Frekuensi</label>
                                    <input type="text" name="items[{{ $index }}][frekuensi]" class="form-control" value="{{ $item['frekuensi'] }}" required>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <label class="form-label">Durasi</label>
                                    <input type="text" name="items[{{ $index }}][durasi]" class="form-control" value="{{ $item['durasi'] }}" required>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <label class="form-label">Jumlah</label>
                                    <input type="number" name="items[{{ $index }}][jumlah]" class="form-control" value="{{ $item['jumlah'] }}" min="1" required>
                                </div>
                                <div class="col-md-1 mb-2 d-flex align-items-end">
                                    @if($loop->first)
                                    <button type="button" class="btn btn-danger btn-remove-item" style="display:none;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    @else
                                    <button type="button" class="btn btn-danger btn-remove-item">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    @endif
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Instruksi</label>
                                    <input type="text" name="items[{{ $index }}][instruksi]" class="form-control" value="{{ $item['instruksi'] ?? '' }}">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn btn-secondary btn-sm mb-3" id="add-medicine-item">
                        <i class="fas fa-plus me-1"></i> Tambah Obat
                    </button>

                    <hr class="my-4">

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Update
                        </button>
                        <a href="{{ route('admin.template-resep.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let itemCount = {{ count($template->items) }};
    
    document.getElementById('add-medicine-item').addEventListener('click', function() {
        const container = document.getElementById('medicine-items');
        const newItem = document.createElement('div');
        newItem.className = 'medicine-item mb-3 p-3 border rounded';
        newItem.innerHTML = `
            <div class="row">
                <div class="col-md-3 mb-2">
                    <label class="form-label">Nama Obat</label>
                    <input type="text" name="items[${itemCount}][nama_obat]" class="form-control" required>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Dosis</label>
                    <input type="text" name="items[${itemCount}][dosis]" class="form-control" placeholder="mis: 500mg" required>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Frekuensi</label>
                    <input type="text" name="items[${itemCount}][frekuensi]" class="form-control" placeholder="mis: 3x1" required>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Durasi</label>
                    <input type="text" name="items[${itemCount}][durasi]" class="form-control" placeholder="mis: 7 hari" required>
                </div>
                <div class="col-md-2 mb-2">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="items[${itemCount}][jumlah]" class="form-control" value="1" min="1" required>
                </div>
                <div class="col-md-1 mb-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-remove-item">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Instruksi</label>
                    <input type="text" name="items[${itemCount}][instruksi]" class="form-control" placeholder="mis: diminum setelah makan">
                </div>
            </div>
        `;
        container.appendChild(newItem);
        itemCount++;
        updateRemoveButtons();
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remove-item')) {
            e.target.closest('.medicine-item').remove();
            updateRemoveButtons();
        }
    });

    function updateRemoveButtons() {
        const items = document.querySelectorAll('.medicine-item');
        items.forEach((item, index) => {
            const btn = item.querySelector('.btn-remove-item');
            if (items.length > 1) {
                btn.style.display = 'block';
            } else {
                btn.style.display = 'none';
            }
        });
    }
</script>
@endpush
@endsection
