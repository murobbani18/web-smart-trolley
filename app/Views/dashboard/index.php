<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>

<div class="container-xl py-4">
    <h1 class="text-center mb-4">Selamat datang di Smart Trolley</h1>

    <div class="row">
        <!-- Dashboard Overview -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Staff</h5>
                    <p class="fs-3 text-center"><?= $total_staff ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Trolley</h5>
                    <p class="fs-3 text-center"><?= $total_trolleys ?></p>
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
        <p>Trolley, daftar barang</p>

        <div class="btn-group">
            <a href="/catalog" class="btn btn-primary">Lihat Katalog Produk</a>
            <!-- <a href="/trolley" class="btn btn-success">Kelola Trolley</a> -->
            <a href="/dashboard/product_details" class="btn btn-success">Lihat Semua Produk</a>
        </div>
    </div>

    <div class="mt-5">
        <h2 class="text-center">Statistik dan Pengelolaan Produk</h2>
        
        <div class="row">
            <!-- Total Produk -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Total Produk</h5>
                    </div>
                    <div class="card-body">
                        <p class="display-4"><?= $total_products ?></p>
                    </div>
                </div>
            </div>

            <!-- Stok Habis -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Produk Habis</h5>
                    </div>
                    <div class="card-body">
                        <p class="display-4"><?= count($out_of_stock) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>
