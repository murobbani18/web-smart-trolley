<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container-xl mt-4">
  <h3 class="mb-4">Keranjang Saya</h3>

  <?php if (empty($cartItems)): ?>
    <div class="alert alert-info">
      <i class="bi bi-info-circle"></i> Keranjang kosong.
    </div>
  <?php else: ?>
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered align-middle">
            <thead class="table-dark">
              <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <!-- <th>Aksi</th> -->
              </tr>
            </thead>
            <tbody>
              <?php 
                $total = 0;
                foreach ($cartItems as $item): 
                  $subtotal = $item['price'] * $item['quantity'];
                  $total += $subtotal;
              ?>
                <tr>
                  <td class="d-flex align-items-center">
                    <img src="<?= base_url('uploads/' . $item['image']) ?>" alt="<?= esc($item['name']) ?>" class="img-fluid me-2" style="width: 50px; height: auto;">
                    <?= esc($item['name']) ?>
                  </td>
                  <td>Rp <?= number_format($item['price'], 0, ',', '.') ?></td>
                  <td>
                    <!-- Form untuk mengubah jumlah -->
                    <!-- <form action="/update-quantity" method="post" class="d-flex">
                      <input type="hidden" name="item_id" value="</?= $item['item_id'] ?>">
                      <input type="number" name="quantity" value="</?= $item['quantity'] ?>" min="1" max="</?= $item['stock'] ?>" class="form-control form-control-sm" style="width: 80px;">
                      <button class="btn btn-sm btn-warning ms-2" type="submit">Update Jumlah</button>
                    </form> -->
                  <?= number_format($item['quantity'], 0, ',', '.') ?>
                  </td>
                  <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                  <!-- <td>
                    <form action="/remove-from-cart" method="post" onsubmit="return confirm('Hapus item ini?')">
                      <input type="hidden" name="item_id" value="</?= $item['item_id'] ?>">
                      <button class="btn btn-sm btn-danger" type="submit">Hapus</button>
                    </form>
                  </td> -->
                </tr>
              <?php endforeach ?>
            </tbody>
            <tfoot>
              <tr>
                <th colspan="3">Total</th>
                <th colspan="2">Rp <?= number_format($total, 0, ',', '.') ?></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  <?php endif ?>
</div>

<?php if (!empty($cartItems)): ?>
  <div class="text-end mt-4" style="display: none">
    <form action="/checkout" method="post">
      <button type="submit" class="btn btn-success">
        <i class="bi bi-credit-card"></i> Bayar Sekarang
      </button>
    </form>
  </div>
<?php endif ?>

<script>
let lastData = null;

function normalizeData(data) {
    // Urutkan berdasarkan item_id dan stringify agar bisa dibandingkan
    return JSON.stringify(
        data.sort((a, b) => a.item_id - b.item_id)
    );
}

function loadTrolleyItems() {
    fetch('/trolley/getItems')
        .then(response => response.json())
        .then(data => {
            const newData = normalizeData(data);

            if (newData !== lastData) {
                if (lastData !== null) {
                    // Hanya reload jika ini bukan pemanggilan pertama
                    location.reload();
                }
                lastData = newData;
            }
        })
        .catch(error => console.error('Fetch error:', error));
}

window.onload = loadTrolleyItems;
setInterval(loadTrolleyItems, 2000);
</script>

<?= $this->endSection() ?>
