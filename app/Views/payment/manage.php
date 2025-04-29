<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>
    <h2>Daftar Pembayaran</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Pembeli</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payments as $payment): ?>
                <tr>
                    <td><?php echo $payment['nama_pembeli']; ?></td>
                    <td><?php echo $payment['jumlah']; ?></td>
                    <td><?php echo number_format($payment['total_harga'], 2); ?></td>
                    <td><?php echo ucfirst($payment['status']); ?></td>
                    <td>
                        <?php if ($payment['status'] == 'pending'): ?>
                            <a href="/payment/validatePayment/<?php echo $payment['id']; ?>">Validasi</a> |
                            <a href="/payment/rejectPayment/<?php echo $payment['id']; ?>">Tolak</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php $this->endSection(); ?>

