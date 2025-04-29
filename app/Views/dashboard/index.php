<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>

<h2>Dashboard</h2>
    <p>Selamat datang, <?php echo session()->get('username'); ?>!</p>
    <p>Ini adalah dashboard staff.</p>
<?php $this->endSection(); ?>
