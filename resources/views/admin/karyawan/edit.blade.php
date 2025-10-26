@extends('layouts.admin')

@section('title', 'Admin - Edit Karyawan')

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
        height: 160px;
        border-radius: 50%;
        object-fit: cover;
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
    .input-group select {
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
    <h3 class="mb-4 text-center fw-bold"><i class="fa-solid fa-user-edit me-2"></i>Edit Data Karyawan</h3>

    <form action="{{ route('admin.karyawan.update', $karyawan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <!-- Foto kiri -->
            <div class="col-md-4 avatar-wrapper">
                <img src="{{ $karyawan->foto ? asset('storage/foto/' . $karyawan->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($karyawan->nama) }}"
                     id="avatarPreview" class="avatar-preview" alt="Foto Profil">
                <div class="w-100">
                    <label for="foto" class="form-label">Ganti Foto Profil</label>
                    <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                    <small class="text-muted">Maks 2MB, JPG/PNG</small>
                    @error('foto')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
            </div>

            <!-- Form kanan -->
            <div class="col-md-8">
                {{-- Nama --}}
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Lengkap</label>
                    <div class="input-group">
                        <i class="fa fa-user"></i>
                        <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $karyawan->nama) }}" required>
                    </div>
                    @error('nama')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                {{-- Jabatan --}}
                <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <div class="input-group">
                        <i class="fa fa-briefcase"></i>
                        <input type="text" name="jabatan" id="jabatan" class="form-control" value="{{ old('jabatan', $karyawan->jabatan) }}" required>
                    </div>
                    @error('jabatan')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <i class="fa fa-envelope"></i>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $karyawan->email) }}" required>
                    </div>
                    @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <div class="input-group">
                        <i class="fa fa-toggle-on"></i>
                        <select name="status" id="status" class="form-select" required>
                            <option value="active" {{ old('status', $karyawan->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $karyawan->status) == 'inactive' ? 'selected' : '' }}>Not Active</option>
                        </select>
                    </div>
                    @error('status')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="btn-group-custom">
            <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left me-1"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save me-1"></i> Perbarui
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Preview real-time saat upload foto
    document.getElementById('foto').addEventListener('change', function (e) {
        const [file] = e.target.files;
        if (file) {
            document.getElementById('avatarPreview').src = URL.createObjectURL(file);
        }
    });
</script>
@endpush
