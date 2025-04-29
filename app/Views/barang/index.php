
<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>
    <h2>Daftar Barang</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($barang as $b): ?>
                <tr>
                    <td><?php echo $b['nama_barang']; ?></td>
                    <td><?php echo number_format($b['harga'], 2); ?></td>
                    <td><?php echo $b['stok']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php $this->endSection(); ?>
