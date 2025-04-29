<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
  <h3 class="mb-4">Validasi Pembayaran</h3>

  <div class="card shadow-sm">
    <div class="card-body">
      <table class="table">
        <thead>
          <tr>
            <th>ID Pembayaran</th>
            <th>Status</th>
            <th>Opsi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($payments as $payment): ?>
            <tr>
              <td><?= esc($payment['id']) ?></td>
              <td>
                <?php if ($payment['status'] == 'pending'): ?>
                  <span class="badge bg-warning">Menunggu Validasi</span>
                <?php elseif ($payment['status'] == 'validated'): ?>
                  <span class="badge bg-success">Divalidasi</span>
                <?php elseif ($payment['status'] == 'cancelled'): ?>
                  <span class="badge bg-secondary">Dibatalkan</span>
                <?php else: ?>
                  <span class="badge bg-danger">Gagal</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($payment['status'] == 'pending'): ?>
                  <a href="/payments/validate/<?= $payment['id'] ?>" class="btn btn-sm btn-success">Validasi</a>
                  <a href="/payments/cancel/<?= $payment['id'] ?>" class="btn btn-sm btn-danger">Batalkan</a>
                <?php elseif ($payment['status'] == 'validated'): ?>
                  <span class="badge bg-success">Pembayaran Sudah Divalidasi</span>
                <?php elseif ($payment['status'] == 'cancelled'): ?>
                  <span class="badge bg-secondary">Dibatalkan</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
