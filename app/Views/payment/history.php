<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container mt-5">
    <h1>Riwayat Pembayaran</h1>

    <?php if (empty($payments)): ?>
        <div class="alert alert-warning">Anda belum melakukan pembayaran.</div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Pembayaran</th>
                    <th>Total Harga</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Status</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($payments as $payment): ?>
                    <tr>
                        <td><?= esc($payment['id']) ?></td>
                        <td>Rp <?= number_format($payment['total_amount'], 2, ',', '.') ?></td>
                        <td><?= date('d-m-Y H:i', strtotime($payment['created_at'])) ?></td>
                        <td>
                        <?php 
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
                        </td>
                        <td>
                            <a href="/payments/detail/<?= esc($payment['id']) ?>" class="btn btn-info btn-sm">Lihat Detail</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
