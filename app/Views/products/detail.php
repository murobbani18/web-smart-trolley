<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>
<div class="container-xl mt-4">
  <div class="row">
    <div class="col-md-6">
      <!-- Gambar Produk -->
      <img src="<?= base_url('uploads/' . $product['image']) ?>" class="img-fluid rounded-3" alt="<?= esc($product['name']) ?>">
    </div>
    <div class="col-md-6">
      <!-- Informasi Produk -->
      <h2 class="fw-bold"><?= esc($product['name']) ?></h2>
      <div class="text-orange fw-semibold mb-2">Rp<?= number_format($product['price'], 0, ',', '.') ?></div>
      <div class="text-muted mb-3">Stok: <?= $product['stock'] ?></div>
      <div class="text-muted mb-3">📍 <?= $product['rack_code'] ?> - <?= $product['position_detail'] ?></div>

      <!-- Deskripsi Produk -->
      <h4 class="mt-3">Deskripsi</h4>
      <p><?= esc($product['description']) ?></p>

      <!-- RFID -->
      <h4 class="mt-3">RFID</h4>
      <p><?= esc($product['rfid_code']) ?></p>

      <!-- Button Kembali -->
      <a href="/products" class="btn btn-secondary mt-3">Kembali ke Daftar Produk</a>
    </div>
  </div>
</div>
<?php $this->endSection(); ?>
