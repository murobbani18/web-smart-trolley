<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>
<h2>Edit Barang</h2>
    <form action="/barang/update/<?php echo $barang['id']; ?>" method="post">
        <label for="nama">Nama Barang:</label>
        <input type="text" name="nama" value="<?php echo $barang['nama_barang']; ?>" required>
        
        <label for="harga">Harga:</label>
        <input type="number" name="harga" value="<?php echo $barang['harga']; ?>" required>
        
        <label for="stok">Stok:</label>
        <input type="number" name="stok" value="<?php echo $barang['stok']; ?>" required>
        
        <button type="submit">Simpan</button>
    </form>
<?php $this->endSection(); ?>
