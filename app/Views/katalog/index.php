<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>
<div class="container-xl mt-4">
  <div class="row row-cards">
    <?php foreach ($items as $item): ?>
      <div class="col-6 col-md-4 col-lg-3">
        <div class="card shadow-sm mb-3">
          <!-- Image with original size and rounded corners -->
          <img src="<?= base_url('uploads/' . $item['image']) ?>" 
               class="card-img-top img-fluid rounded-3" 
               style="height: auto; max-height: 200px; object-fit: contain; border-radius: 10px;" 
               alt="<?= esc($item['name']) ?>">
               
          <div class="card-body p-3">
            <!-- Item Name -->
            <h5 class="card-title text-truncate"><?= esc($item['name']) ?></h5>

            <!-- Price -->
            <div class="text-primary fw-bold mb-2">Rp <?= number_format($item['price'], 0, ',', '.') ?></div>

            <!-- Stock -->
            <div class="text-muted text-xs">Stok: <?= $item['stock'] ?> items</div>

            <!-- Location -->
            <div class="text-muted text-xs my-2">
              <span class="badge bg-light-secondary">📍 <?= $item['rack_code'] ?> - <?= $item['position_detail'] ?></span>
            </div>

            <!-- Actions: View Details and Add to Cart -->
            <div class="d-flex justify-content-between">
              <a href="/products/detail/<?= $item['id'] ?>" class="btn btn-sm btn-primary">Lihat Detail</a>
              <form action="/add-to-cart" method="post" class="d-flex align-items-center">
                <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                <input type="number" name="quantity" value="1" min="1" max="<?= $item['stock'] ?>" class="form-control form-control-sm me-2" style="width: 60px;">
                <button type="submit" class="btn btn-sm btn-success">Tambah</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach ?>
  </div>
</div>
<?php $this->endSection(); ?>
