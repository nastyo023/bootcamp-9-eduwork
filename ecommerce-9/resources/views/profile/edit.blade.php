<x-app-layout title="Pengaturan Profil">
    <div class="container my-5">
        <h3 class="fw-bold mb-4"><i class="bi bi-person-circle me-2"></i>Pengaturan Profil</h3>

        <div class="row g-4">
            <!-- Form Informasi Diri -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Informasi Akun</h5>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label for="name" class="form-label fw-medium">Nama Lengkap</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label fw-medium">Alamat Email</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label fw-medium">Nomor Telepon / Whatsapp</label>
                                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone ?? '') }}" placeholder="08123456789">
                            </div>

                            <button type="submit" class="btn btn-primary fw-bold px-4 rounded-pill">
                                Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Form Ubah Password -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Ubah Kata Sandi</h5>

                        @if(session('success_password'))
                            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-3" role="alert">
                                {{ session('success_password') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('profile.password') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="current_password" class="form-label fw-medium">Kata Sandi Saat Ini</label>
                                <input type="password" name="current_password" id="current_password" class="form-control" required>
                                @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-medium">Kata Sandi Baru</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label fw-medium">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                            </div>

                            <button type="submit" class="btn btn-outline-danger fw-bold px-4 rounded-pill">
                                Perbarui Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>