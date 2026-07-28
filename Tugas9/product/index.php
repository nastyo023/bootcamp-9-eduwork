<?php
$page_title = "Beranda - WebDev App"; 
include_once '../template/header.php';
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<?php

// show all products from the database in html table format
require_once '../connect.php';

// Get search and filter parameters
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';

// Get all categories for filter dropdown
$sql_categories = "SELECT DISTINCT category FROM products ORDER BY category";
$stmt_categories = $pdo->query($sql_categories);
$categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

// Build SQL query with search and filter
$sql = "SELECT * FROM products WHERE 1=1";
$params = [];

if (!empty($search)) {
    $sql .= " AND name LIKE ?";
    $params[] = "%{$search}%";
}

if (!empty($category)) {
    $sql .= " AND category = ?";
    $params[] = $category;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<main class="container my-5">
    <h1 class="mb-4">Daftar Produk</h1>
    <a href="create.php" class="btn btn-primary mb-3">Tambah Produk</a>
    <table class="table table-bordered table-striped" id="productsTable">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
                <th>Stok</th>
                <th>Kategori</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['id']); ?></td>
                    <td><?= htmlspecialchars($product['name']); ?></td>
                    <td><?= htmlspecialchars($product['price']); ?></td>
                    <td><?= htmlspecialchars($product['description']); ?></td>
                    <td><img src="../uploads/<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" width="100"></td>
                    <td><?= htmlspecialchars($product['stock']); ?></td>
                    <td><?= htmlspecialchars($product['category']); ?></td>
                    <td>
                        <a href="edit.php?id=<?= htmlspecialchars($product['id']); ?>" class="btn btn-sm btn-warning">Edit</a>
                        <form action="db_action/delete.php" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']); ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($products)): ?>
                <tr>
                    <td colspan="8" class="text-center">Tidak ada produk ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#productsTable').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
        },
        "pageLength": 10,
        "order": [[0, "desc"]],
        "columnDefs": [
            {
                "targets": -1,
                "orderable": false,
                "searchable": false
            }
        ]
    });
});
</script>
<?php include_once '../template/footer.php'; ?>