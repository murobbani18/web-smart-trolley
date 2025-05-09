<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
  <h3 class="mb-4">Pembayaran</h3>

  <div class="card">
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
        <li class="nav-item">
          <a href="#tabs-validasi" class="nav-link active"
            data-bs-toggle="tab">Validasi Pembayaran</a>
        </li>
        <li class="nav-item">
          <a href="#tabs-history" class="nav-link"
            data-bs-toggle="tab">History Pembayaran</a>
        </li>
      </ul>
    </div>
    <div class="card-body">
      <div class="tab-content">
        <div class="tab-pane active show" id="tabs-validasi">
          <!-- <h4>Validasi Pembayaran</h4> -->
          <?php if (count($payments)===0): ?>
          <div style="display:flex; flex-direction: column; justify-content: center; align-items: center; min-height: 400px; gap: 1rem">
            <div style="position:relative">
              <img src="/assets/img/empty-pending-payment.jpg" style="height:200px"/>
              <span class="text-muted" style="position:absolute; bottom:-10px; right:0; font-size:.8rem"><i>Image by <a href="https://www.freepik.com/free-vector/flat-worried-woman-have-list-credit-debts-overdue-bills-girl-reading-letter-from-collection-agency-about-financial-problems-loans-unpaid-tax-calculation-payment-expenses-concept_22654317.htm#fromView=search&page=1&position=23&uuid=5f51ae80-df41-4fb7-9c10-8b7e139ca8aa&query=empty+payment">Freepick</a></i></span>
            </div>
            <h4 class="text-muted" style="font-weight:500; font-size:1.2rem"><i>Belum ada pembayaran yang menunggu validasi.</i></h4>
          </div>
          <?php else: ?>
          <div>
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
                        <a href="/payments/detail/<?= esc($payment['id']) ?>" class="btn btn-sm btn-info">Lihat Detail</a>
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
          <?php endif;?>
        </div>
        <div class="tab-pane" id="tabs-history">
          <!-- <h4>History Pembayaran</h4> -->
           
          <?php if (count($paymentsHistory)===0): ?>
          <div style="display:flex; flex-direction: column; justify-content: center; align-items: center; min-height: 400px; gap: 1rem">
            <div style="position:relative">
              <img src="/assets/img/empty-history.jpg" style="height:200px"/>
              <span class="text-muted" style="position:absolute; bottom:0px; right:0; font-size:.8rem"><i>Image by <a href="https://www.freepik.com/free-vector/flat-worried-woman-have-list-credit-debts-overdue-bills-girl-reading-letter-from-collection-agency-about-financial-problems-loans-unpaid-tax-calculation-payment-expenses-concept_22654317.htm#fromView=search&page=1&position=23&uuid=5f51ae80-df41-4fb7-9c10-8b7e139ca8aa&query=empty+payment">Freepick</a></i></span>
            </div>
            <h4 class="text-muted" style="font-weight:500; font-size:1.2rem"><i>Tidak ada history pembayaran.</i></h4>
          </div>
          <?php else: ?>
          <div>
            <table class="table">
              <thead>
                <tr>
                  <th>ID Pembayaran</th>
                  <th>Status</th>
                  <th>Opsi</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($paymentsHistory as $payment): ?>
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
                        <a href="/payments/detail/<?= esc($payment['id']) ?>" class="btn btn-sm btn-info">Lihat Detail</a>
                      <?php elseif ($payment['status'] == 'validated'): ?>
                        <span class="badge bg-success text-white">Pembayaran Sudah Divalidasi</span>
                      <?php elseif ($payment['status'] == 'cancelled'): ?>
                        <span class="badge bg-secondary text-white">Dibatalkan</span>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <?php endif;?>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
