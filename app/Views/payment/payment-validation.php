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
                <?php 
                  // Menampilkan status pembayaran dengan badge dan warna sesuai Tabler
                  switch ($payment['status']) {
                      case 'pending':
                          echo '<span class="badge bg-yellow text-yellow-fg">Menunggu Verifikasi</span>';
                          break;
                      case 'paid':
                          echo '<span class="badge bg-blue text-blue-fg">Sudah Dibayar</span>';
                          break;
                      case 'validated':
                          echo '<span class="badge bg-green text-green-fg">Terverifikasi</span>';
                          break;
                      case 'cancelled':
                          echo '<span class="badge bg-red text-red-fg">Dibatalkan</span>';
                          break;
                      default:
                          echo '<span class="badge bg-secondary text-secondary-fg">Status Tidak Dikenal</span>';
                          break;
                  }
              ?>
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
