<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>

<h2>Kelola Barang</h2>
    <a href="/barang/edit" class="btn">Tambah Barang</a>
    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($barang as $b): ?>
                <tr>
                    <td><?php echo $b['nama_barang']; ?></td>
                    <td><?php echo number_format($b['harga'], 2); ?></td>
                    <td><?php echo $b['stok']; ?></td>
                    <td>
                        <a href="/barang/edit/<?php echo $b['id']; ?>">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php $this->endSection(); ?>
