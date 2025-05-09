<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">Daftar Produk</h2>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <a href="/products/create" class="btn btn-primary">
          + Tambah Produk
        </a>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead class="table-dark">
              <tr>
                <th>Image</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Deskripsi</th>
                <th>RFID</th>
                <th>Rak</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($products as $p): ?>
              <tr>
                <td><img src="/uploads/<?= esc($p['image']) ?>" alt="Gambar Produk" style="max-height: 80px;"></td>
                <td><?= esc($p['name']) ?></td>
                <td>Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
                <td><?= esc($p['stock']) ?></td>
                <td><?= esc($p['description']) ?></td>
                <td>
                  <ul>
                    <?php
                    foreach($p['rfids'] as $rfid) {
                      echo '<li>' . esc($rfid['rfid_code']) . '</li>';
                    }
                    ?>
                  </ul>
                </td>
                <td><?= esc($p['rack_code']) ?> - <?= esc($p['position_detail']) ?></td>
                <td class="d-flex gap-2">
                  <a href="/products/edit/<?= $p['id'] ?>" class="btn btn-sm btn-warning">
                    Edit
                  </a>
                  <form action="/products/delete/<?= $p['id'] ?>" method="post" onsubmit="return confirm('Hapus produk ini?')">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                  </form>
                </td>
              </tr>
              <?php endforeach; ?>
              <?php if (empty($products)): ?>
              <tr>
                <td colspan="5" class="text-center text-muted">Belum ada produk.</td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>

<?php $this->endSection(); ?>
