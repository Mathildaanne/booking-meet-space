@extends('layouts.admin')

@section('title', 'Admin - Tambah Ruangan')

@section('styles')
<!-- Font Awesome & Bootstrap -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    .form-wrapper {
        max-width: 960px;
        margin: 3rem auto;
        background: #fff;
        border-radius: 15px;
        padding: 2.5rem 3rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        animation: fadeInUp 0.5s ease-in-out;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .form-title {
        text-align: center;
        font-weight: 700;
        font-size: 1.9rem;
        margin-bottom: 2rem;
        color: #333;
    }

    .input-group i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        font-size: 1rem;
    }

    .input-group input,
    .input-group select,
    .input-group textarea {
        width: 100%;
        padding: 10px 14px 10px 2.8rem;
        border: 1px solid #ced4da;
        border-radius: 10px;
        font-size: 15px;
    }

    .input-group input:focus,
    .input-group select:focus,
    .input-group textarea:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, .15);
        outline: none;
    }

    .preview-img {
        width: 150px;
        height: 100px;
        border-radius: 10px;
        object-fit: cover;
        border: 4px solid #edf2f7;
        box-shadow: 0 4px 15px rgba(0, 0, 0, .1);
        margin-bottom: 15px;
    }

    .btn-group-custom {
        display: flex;
        justify-content: flex-end;
        gap: .75rem;
        margin-top: 2rem;
        border-top: 1px solid #ddd;
        padding-top: 1.5rem;
    }

    .btn {
        border-radius: 10px;
        font-weight: 600;
        padding: 10px 22px;
        font-size: 15px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        border: none;
        color: #fff;
    }

    .btn-secondary {
        background-color: #f8f9fa;
        color: #333;
        border: 1px solid #ced4da;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="form-wrapper">
        <div class="form-title">
            <i class="fa-solid fa-door-open me-2"></i>Tambah Data Ruangan
        </div>

        <form method="POST" action="{{ route('admin.ruang.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <!-- Kiri: Preview Gambar -->
                <div class="col-md-4 text-center">
                    <img src="https://via.placeholder.com/150x100.png?text=Preview" id="previewFoto" class="preview-img" alt="Preview Ruangan">
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Ruangan</label>
                        <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                        <small class="text-muted">Maks 2MB • JPG/PNG</small>
                        @error('foto')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Kanan: Form Input -->
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Ruangan</label>
                        <div class="input-group position-relative">
                            <i class="fa fa-door-closed"></i>
                            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" placeholder="Contoh: Ruang Meeting A" required>
                        </div>
                        @error('nama')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="kapasitas" class="form-label">Kapasitas</label>
                        <div class="input-group position-relative">
                            <i class="fa fa-users"></i>
                            <input type="number" name="kapasitas" id="kapasitas" class="form-control" value="{{ old('kapasitas') }}" placeholder="Contoh: 10" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="jam_buka" class="form-label">Jam Buka</label>
                        <div class="input-group position-relative">
                            <i class="fa fa-clock"></i>
                            <input type="time" name="jam_buka" id="jam_buka" class="form-control" value="{{ old('jam_buka') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="jam_tutup" class="form-label">Jam Tutup</label>
                        <div class="input-group position-relative">
                            <i class="fa fa-clock"></i>
                            <input type="time" name="jam_tutup" id="jam_tutup" class="form-control" value="{{ old('jam_tutup') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="lantai" class="form-label">Lantai</label>
                        <div class="input-group position-relative">
                            <i class="fa fa-building"></i>
                            <input type="number" name="lantai" id="lantai" class="form-control" value="{{ old('lantai') }}" placeholder="Contoh: 1">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="fasilitas" class="form-label">Fasilitas</label>
                        <div class="input-group position-relative">
                            <i class="fa fa-list-ul"></i>
                            <textarea name="fasilitas" id="fasilitas" class="form-control" rows="3" placeholder="Contoh: Wifi, Proyektor, AC">{{ old('fasilitas') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="btn-group-custom">
                <a href="{{ route('admin.ruang.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left me-1"></i> Kembali</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i> Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('foto').addEventListener('change', function(e) {
        const [file] = e.target.files;
        if (file) {
            document.getElementById('previewFoto').src = URL.createObjectURL(file);
        }
    });
</script>
@endpush
  