@extends('layouts.admin')

@section('title', 'Admin - Edit Ruangan')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .form-wrapper {
        width: 100%;
        max-width: 1000px;
        margin: 3rem auto;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        padding: 2.5rem 3rem;
        animation: fadeInUp 0.5s ease-in-out;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .avatar-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        border-right: 1px solid #ddd;
        padding-right: 2rem;
    }

    .avatar-preview {
        width: 160px;
        height: 120px;
        object-fit: cover;
        border-radius: 12px;
        border: 4px solid #edf2f7;
        box-shadow: 0 4px 15px rgba(0, 0, 0, .1);
        margin-bottom: 1rem;
    }

    .form-label { font-weight: 600; margin-bottom: 6px; color: #444; }

    .input-group i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    .input-group input,
    .input-group select,
    .input-group textarea {
        padding-left: 2.5rem;
    }

    .btn-group-custom {
        display: flex;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: .75rem;
        margin-top: 2rem;
        border-top: 1px solid #ddd;
        padding-top: 1.5rem;
    }
</style>
@endsection

@section('content')
<div class="form-wrapper">
    <h3 class="mb-4 text-center fw-bold"><i class="fa-solid fa-door-open me-2"></i>Edit Data Ruangan</h3>

    <form method="POST" action="{{ route('admin.ruang.update', $ruang->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <!-- Kiri: Foto -->
            <div class="col-md-4 avatar-wrapper">
                <img src="{{ $ruang->foto ? asset('storage/' . $ruang->foto) : 'https://via.placeholder.com/160x120?text=Foto+Ruangan' }}"
                     id="fotoPreview" class="avatar-preview" alt="Foto Ruangan">
                <div class="w-100">
                    <label for="foto" class="form-label">Ganti Foto Ruangan</label>
                    <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                    <small class="text-muted">Maks 2MB • JPG/PNG</small>
                    @error('foto')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
            </div>

            <!-- Kanan: Form -->
            <div class="col-md-8">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Ruangan</label>
                    <div class="input-group">
                        <i class="fa fa-door-closed"></i>
                        <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $ruang->nama) }}" required>
                    </div>
                    @error('nama')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="kapasitas" class="form-label">Kapasitas</label>
                    <div class="input-group">
                        <i class="fa fa-users"></i>
                        <input type="number" name="kapasitas" id="kapasitas" class="form-control" value="{{ old('kapasitas', $ruang->kapasitas) }}" required>
                    </div>
                    @error('kapasitas')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="jam_buka" class="form-label">Jam Buka</label>
                    <div class="input-group">
                        <i class="fa fa-clock"></i>
                        <input type="time" name="jam_buka" id="jam_buka" class="form-control" value="{{ old('jam_buka', $ruang->jam_buka) }}" required>
                    </div>
                    @error('jam_buka')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="jam_tutup" class="form-label">Jam Tutup</label>
                    <div class="input-group">
                        <i class="fa fa-clock"></i>
                        <input type="time" name="jam_tutup" id="jam_tutup" class="form-control" value="{{ old('jam_tutup', $ruang->jam_tutup) }}" required>
                    </div>
                    @error('jam_tutup')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="lantai" class="form-label">Lantai</label>
                    <div class="input-group">
                        <i class="fa fa-building"></i>
                        <input type="number" name="lantai" id="lantai" class="form-control" value="{{ old('lantai', $ruang->lantai) }}">
                    </div>
                    @error('lantai')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="fasilitas" class="form-label">Fasilitas</label>
                    <div class="input-group">
                        <i class="fa fa-couch"></i>
                        <textarea name="fasilitas" id="fasilitas" rows="3" class="form-control">{{ old('fasilitas', $ruang->fasilitas) }}</textarea>
                    </div>
                    @error('fasilitas')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="btn-group-custom">
            <a href="{{ route('admin.ruang.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left me-1"></i> Batal</a>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i> Update</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('foto').addEventListener('change', function (e) {
        const [file] = e.target.files;
        if (file) {
            document.getElementById('fotoPreview').src = URL.createObjectURL(file);
        }
    });
</script>
@endpush
