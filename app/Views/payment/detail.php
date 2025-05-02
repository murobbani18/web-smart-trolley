<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1>Detail Pembayaran</h1>

    <div class="card">
        <div class="card-header">
            <h5>Informasi Pembayaran</h5>
        </div>
        <div class="card-body">
            <p><strong>ID Pembayaran:</strong> <?= esc($payment['id']) ?></p>
            <p><strong>User ID:</strong> <?= esc($payment['user_id']) ?></p>
            <p><strong>Total Harga:</strong> Rp <?= number_format($payment['total_amount'], 2, ',', '.') ?></p>
            <p><strong>Tanggal Pembayaran:</strong> <?= date('d-m-Y H:i', strtotime($payment['created_at'])) ?></p>
            <p><strong>Status Pembayaran:</strong> 
            <?php 
                // Menampilkan status pembayaran dengan badge dan warna sesuai Tabler
                switch ($payment['status']) {
                    case 'pending':
                        echo '<span class="badge bg-yellow text-yellow-fg">Menunggu Verifikasi</span>';
                        break;
                    case 'paid':
                        echo '<span class="badge bg-blue text-blue-fg">Sudah Dibayar</span>';
                        break;
                    case 'validated':
                        echo '<span class="badge bg-green text-green-fg">Terverifikasi</span>';
                        break;
                    case 'cancelled':
                        echo '<span class="badge bg-red text-red-fg">Dibatalkan</span>';
                        break;
                    default:
                        echo '<span class="badge bg-secondary text-secondary-fg">Status Tidak Dikenal</span>';
                        break;
                }
            ?>
            </p>
        </div>
    </div>

    <h2 class="mt-4">Detail Item Pembayaran</h2>
    <?php if (!empty($paymentItems)): ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Item</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($paymentItems as $item): ?>
                <tr>
                    <td><?= esc($item['name']) ?></td>
                    <td>Rp <?= number_format($item['price'], 2, ',', '.') ?></td>
                    <td><?= esc($item['quantity']) ?></td>
                    <td>Rp <?= number_format($item['price'] * $item['quantity'], 2, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p class="alert alert-warning">Tidak ada item dalam pembayaran ini.</p>
    <?php endif; ?>
    <div class="mt-3">
        <button class="btn btn-primary" onclick="window.history.back()">Kembali</button>
    </div>

    <!-- <div class="mt-3">
        <a href="/payments" class="btn btn-primary">Kembali ke Daftar Pembayaran</a>
    </div> -->
</div>
<?= $this->endSection() ?>
