<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <h2 class="page-title">Edit Produk</h2>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <form action="/products/update/<?= $product['id'] ?>" method="post" enctype="multipart/form-data" class="card">
            <div class="card-body">
                <?= csrf_field() ?>

                <!-- Gambar Saat Ini -->
                <?php if (!empty($product['image'])): ?>
                    <div class="mb-3">
                        <label class="form-label">Gambar Saat Ini</label><br>
                        <img src="<?= base_url('uploads/' . $product['image']) ?>" alt="Gambar Produk" style="max-height: 120px; border-radius: 8px;">
                    </div>
                <?php endif; ?>

                <!-- Ganti Gambar -->
                <div class="mb-3">
                    <label class="form-label">Ganti Gambar</label>
                    <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                    <div class="mt-2">
                        <img id="imagePreview" src="#" alt="Preview" style="display: none; max-height: 120px; border-radius: 8px;">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="name" class="form-control" value="<?= esc($product['name']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga</label>
                    <input type="number" name="price" class="form-control" value="<?= esc($product['price']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stock" class="form-control" value="<?= esc($product['stock']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control"><?= esc($product['description']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rack Code</label>
                    <input type="text" name="rack_code" class="form-control" value="<?= esc($product['rack_code']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Detail Posisi</label>
                    <input type="text" name="position_detail" class="form-control" value="<?= esc($product['position_detail']) ?>">
                </div>
                <?php
                    $rfidString = '';
                    foreach($product['rfids'] as $rfid) {
                        $rfidString .= $rfid['rfid_code'] . ',';
                    }
                ?>
                <div class="mb-3">
                    <label class="form-label">RFID Code</label>
                    <input type="text" name="rfid_code" class="form-control" value="<?= esc($rfidString) ?>" autofocus>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

<script>

    // The DOM element you wish to replace with Tagify
    var input = document.querySelector('input[name=rfid_code]');

    // initialize Tagify on the above input node reference
    new Tagify(input)

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