<?php
session_start();

// Ambil error, data lama, dan pesan sukses dari session (jika ada)
$errors  = $_SESSION['errors'] ?? [];
$old     = $_SESSION['old'] ?? [];
$success = $_SESSION['success'] ?? '';

// Hapus session setelah diambil agar tidak muncul terus saat di-refresh
unset($_SESSION['errors'], $_SESSION['old'], $_SESSION['success']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Produk</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Style Tambahan untuk Tampilan Modern -->
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card-custom {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }
        .form-control, .form-select {
            border-radius: 0.5rem;
            padding: 0.6rem 0.9rem;
            border-color: #dee2e6;
        }
        .form-control:focus, .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
        .input-group-text {
            border-radius: 0.5rem 0 0 0.5rem;
            background-color: #f8f9fa;
        }
        .input-group .form-control {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
        .btn-primary-custom {
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.3px;
        }
    </style>
</head>
<body class="py-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <div class="card card-custom bg-white">
                <div class="card-body p-4 p-md-5">
                    
                    <!-- Header -->
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-dark mb-1">Tambah Produk</h3>
                        <p class="text-muted small">Lengkapi formulir di bawah ini untuk menambahkan produk baru</p>
                    </div>

                    <!-- Pesan Sukses -->
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                            <strong>Berhasil!</strong> <?= $success ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="proses_produk.php" method="POST" enctype="multipart/form-data" novalidate>
                        
                        <!-- Nama Produk -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold text-secondary small">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" 
                                   id="name" 
                                   name="name" 
                                   value="<?= htmlspecialchars($old['name'] ?? '') ?>" 
                                   placeholder="Contoh: Sepatu Lari Lightweight">
                            <?php if (isset($errors['name'])): ?>
                                <div class="invalid-feedback"><?= $errors['name'] ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Kategori -->
                        <div class="mb-3">
                            <label for="category" class="form-label fw-semibold text-secondary small">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select <?= isset($errors['category']) ? 'is-invalid' : '' ?>" 
                                    id="category" 
                                    name="category">
                                <option value="">-- Pilih Kategori --</option>
                                <?php 
                                $categories = ['Elektronik', 'Pakaian', 'Makanan', 'Aksesoris'];
                                $selectedCategory = $old['category'] ?? '';
                                foreach ($categories as $cat): 
                                ?>
                                    <option value="<?= $cat ?>" <?= $selectedCategory === $cat ? 'selected' : '' ?>><?= $cat ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (isset($errors['category'])): ?>
                                <div class="invalid-feedback"><?= $errors['category'] ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Harga & Stok (Grid) -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label fw-semibold text-secondary small">Harga <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text text-muted">Rp</span>
                                    <input type="number" 
                                           step="0.01" 
                                           class="form-control <?= isset($errors['price']) ? 'is-invalid' : '' ?>" 
                                           id="price" 
                                           name="price" 
                                           value="<?= htmlspecialchars($old['price'] ?? '') ?>" 
                                           placeholder="150000">
                                    <?php if (isset($errors['price'])): ?>
                                        <div class="invalid-feedback"><?= $errors['price'] ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="stock" class="form-label fw-semibold text-secondary small">Stok <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control <?= isset($errors['stock']) ? 'is-invalid' : '' ?>" 
                                       id="stock" 
                                       name="stock" 
                                       value="<?= htmlspecialchars($old['stock'] ?? '') ?>" 
                                       placeholder="25">
                                <?php if (isset($errors['stock'])): ?>
                                    <div class="invalid-feedback"><?= $errors['stock'] ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold text-secondary small">Deskripsi Produk</label>
                            <textarea class="form-control <?= isset($errors['description']) ? 'is-invalid' : '' ?>" 
                                      id="description" 
                                      name="description" 
                                      rows="3" 
                                      placeholder="Tuliskan spesifikasi atau keunggulan produk..."><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
                            <?php if (isset($errors['description'])): ?>
                                <div class="invalid-feedback"><?= $errors['description'] ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Gambar Produk -->
                        <div class="mb-4">
                            <label for="image" class="form-label fw-semibold text-secondary small">Gambar Produk <span class="text-danger">*</span></label>
                            <input class="form-control <?= isset($errors['image']) ? 'is-invalid' : '' ?>" 
                                   type="file" 
                                   id="image" 
                                   name="image" 
                                   accept="image/png, image/jpeg, image/jpg, image/webp">
                            <div class="form-text mt-1 text-muted small">Format: JPG, JPEG, PNG, WEBP (Maksimal 2MB)</div>
                            <?php if (isset($errors['image'])): ?>
                                <div class="invalid-feedback"><?= $errors['image'] ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="d-grid pt-2">
                            <button type="submit" class="btn btn-primary btn-primary-custom">Simpan Produk</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>