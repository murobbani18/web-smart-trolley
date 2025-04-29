<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>
    <h2>Pembayaran untuk <?php echo $barang['nama_barang']; ?></h2>
    <form action="/payment/store" method="post">
        <input type="hidden" name="barang_id" value="<?php echo $barang['id']; ?>">
        
        <label for="jumlah">Jumlah:</label>
        <input type="number" name="jumlah" required>
        
        <label for="nama_pembeli">Nama Pembeli:</label>
        <input type="text" name="nama_pembeli" required>
        
        <button type="submit">Bayar</button>
    </form>
<?php $this->endSection(); ?>
