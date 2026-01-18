@extends('layouts.admin')
@section('title', 'Admin - Tambah Karyawan')

@section('styles')
<!-- Font Awesome -->
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
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-title {
        text-align: center;
        font-weight: 700;
        font-size: 1.9rem;
        margin-bottom: 2rem;
        color: #333;
    }

    .input-group {
        position: relative;
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
    .input-group select {
        width: 100%;
        padding: 10px 14px 10px 2.8rem;
        border: 1px solid #ced4da;
        border-radius: 10px;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .input-group input:focus,
    .input-group select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, .15);
        outline: none;
    }

    .avatar-preview {
        width: 150px;
        height: 150px;
        border-radius: 50%;
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

    .card-avatar {
        padding: 1.5rem;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.03);
        border-radius: 10px;
        background: #f8fafc;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="form-wrapper">
        <div class="form-title">
            <i class="fa-solid fa-user-plus me-2"></i>Tambah Data Karyawan
        </div>

        <form action="{{ route('admin.karyawan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <!-- Kiri: Avatar -->
                <div class="col-12 col-md-4 text-center">
                    <div class="card-avatar">
                        <img src="https://ui-avatars.com/api/?name=User&background=0D6EFD&color=fff&size=512" id="avatarPreview" class="avatar-preview" alt="Foto Profil">
                        <div class="mb-3 mt-2">
                            <label for="foto" class="form-label">Foto Profil</label>
                            <input class="form-control" type="file" name="foto" id="foto" accept="image/*">
                            <small class="text-muted">Maks 2MB • JPG/PNG</small>
                            @error('foto')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- Kanan: Form -->
                <div class="col-12 col-md-8">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <div class="input-group">
                            <i class="fa fa-user"></i>
                            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" placeholder="Nama lengkap" required>
                        </div>
                        @error('nama')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <div class="input-group">
                            <i class="fa fa-briefcase"></i>
                            <select name="jabatan" id="jabatan" class="form-select" required>
                                <option disabled selected>-- Pilih Jabatan --</option>
                                <option value="Manager" {{ old('jabatan') == 'Manager' ? 'selected' : '' }}>Manager</option>
                                <option value="Admin" {{ old('jabatan') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="Staff" {{ old('jabatan') == 'Staff' ? 'selected' : '' }}>Staff</option>
                            </select>
                        </div>
                        @error('jabatan')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>



                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <i class="fa fa-envelope"></i>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email aktif" value="{{ old('email') }}" required>
                        </div>
                        @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <div class="input-group">
                            <i class="fa fa-toggle-on"></i>
                            <select name="status" id="status" class="form-select" required>
                                <option value="active">Aktif</option>
                                <option value="inactive">Nonaktif</option>

                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="btn-group-custom">
                <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary"><i class="fa fa-arrow-left me-1"></i> Kembali</a>
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
            document.getElementById('avatarPreview').src = URL.createObjectURL(file);
        }
    });

    document.getElementById('togglePass').addEventListener('click', function() {
        const input = document.getElementById('password');
        if (input.type === 'password') {
            input.type = 'text';
            this.innerHTML = '<i class="fa fa-eye-slash"></i>';
        } else {
            input.type = 'password';
            this.innerHTML = '<i class="fa fa-eye"></i>';
        }
    });
</script>
@endpush