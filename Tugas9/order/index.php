<?php
$page_title = "Order - WebDev App";
include_once '../template/header.php';

require_once '../connect.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Handle update status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'update_status') {
        $order_id = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
        $status = isset($_POST['status']) ? trim($_POST['status']) : '';

        if ($order_id > 0 && !empty($status)) {
            $sql_update = "UPDATE orders SET status = ? WHERE id = ?";
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->execute([$status, $order_id]);
            header('Location: index.php?search=' . urlencode($search));
            exit();
        }
    }
}

// Build SQL query with search
$sql = "SELECT * FROM orders WHERE 1=1";
$params = [];
if (!empty($search)) {
    $sql .= " AND customer_name LIKE ?";
    $params[] = "%{$search}%";
}
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<main class="container my-5">
    <h1 class="mb-4">Daftar Order</h1>
    <form class="mb-4" method="GET" action="">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Cari berdasarkan nama pelanggan..." value="<?= htmlspecialchars($search); ?>">
            <button class="btn btn-primary" type="submit">Cari</button>
        </div>
    </form>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama Pelanggan</th>
                <th>Email</th>
                <th>Nomor Telepon</th>
                <th>Alamat</th>
                <th>Metode Pembayaran</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Tanggal Order</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($orders)): ?>
                <tr>
                    <td colspan="10" class="text-center">Tidak ada order ditemukan.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['id']); ?></td>
                        <td><?= htmlspecialchars($order['name']); ?></td>
                        <td><?= htmlspecialchars($order['email']); ?></td>
                        <td><?= htmlspecialchars($order['phone']); ?></td>
                        <td><?= htmlspecialchars($order['address']); ?></td>
                        <td><?= htmlspecialchars(str_replace('_', ' ', $order['payment_method'])); ?></td>
                        <td>Rp <?= number_format($order['total_amount'], 0, ',', '.'); ?></td>
                        <td>
                            <form method="POST" class="d-inline">
                                <input type="hidden" name="action" value="update_status">
                                <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                                <select name="status" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit();">
                                    <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
                                    <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td><?= htmlspecialchars($order['created_at']); ?></td>
                        <td>
                            <a href="../success.php?order_id=<?= $order['id']; ?>" class="btn btn-info btn-sm">Lihat</a>
                            <form action="delete.php" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus order ini?');">
                                <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</main>
<?php include_once '../template/footer.php'; ?>