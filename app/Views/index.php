<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>
<div class="container-xl py-4">
    <h1 class="text-center mb-4">Selamat datang di Smart Trolley</h1>

    <div class="row">
        <!-- Dashboard Overview -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Buku</h5>
                    <p class="fs-3 text-center" id="total-books">Loading...</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Trolley</h5>
                    <p class="fs-3 text-center" id="total-trolleys">Loading...</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Status Sistem</h5>
                    <p class="fs-3 text-center" id="system-status">Online</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-5 text-center">
        <h2>Fitur Utama</h2>
        <p>Manajemen Buku, Trolley, dan Status Perpustakaan</p>

        <div class="btn-group">
            <a href="/catalog" class="btn btn-primary">Lihat Katalog Buku</a>
            <a href="/trolley" class="btn btn-success">Kelola Trolley</a>
        </div>
    </div>
</div>

<script>
    // Mengambil data statistik dengan AJAX
    $.ajax({
        url: 'http://localhost:8080/dashboard-stats',  // Gantilah dengan endpoint yang benar
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            // Update statistik pada halaman
            $('#total-books').text(data.totalBooks || '0');
            $('#total-trolleys').text(data.totalTrolleys || '0');
            $('#system-status').text('Online');  // Atau bisa disesuaikan jika ada status sistem
        },
        error: function(xhr, status, error) {
            console.error('Gagal mengambil data statistik:', error);
            $('#total-books').text('Error');
            $('#total-trolleys').text('Error');
            $('#system-status').text('Offline');
        }
    });
</script>

<?php $this->endSection(); ?>
