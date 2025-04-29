<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <h2 class="page-title">Tambah Produk</h2>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <form action="/products/store" method="post" class="card" enctype="multipart/form-data">
            <div class="card-body">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label class="form-label">Gambar Produk</label>
                    <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                    <div class="mt-2">
                        <img id="imagePreview" src="#" alt="Preview" style="display: none; max-height: 120px; border-radius: 8px;">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="name" class="form-control" placeholder="Nama Produk" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="price" class="form-control" placeholder="Harga" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stock" class="form-control" placeholder="Stok" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" placeholder="Deskripsi"></textarea>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Rack Code</label>
                    <input type="text" name="rack_code" class="form-control" placeholder="Kode Rak">
                </div>

                <div class="mb-3">
                    <label class="form-label">Detail Posisi</label>
                    <input type="text" name="position_detail" class="form-control" placeholder="Contoh: Rak bawah kiri">
                </div>

                <div class="mb-3">
                    <label class="form-label">RFID Code</label>
                    <input type="text" name="rfid_code" class="form-control" placeholder="Kode RFID">
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>
<script>
    function previewImage(event) {
        const input = event.target;
        const reader = new FileReader();

        reader.onload = function() {
            const imgElement = document.getElementById('imagePreview');
            imgElement.src = reader.result;
            imgElement.style.display = 'block';
        };

        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<?php $this->endSection(); ?>