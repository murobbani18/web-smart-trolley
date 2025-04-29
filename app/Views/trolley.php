<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>

<div class="container-xl py-4">
    <h1 class="text-center mb-4">Buku di Troli</h1>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="trolley-table" class="table table-striped table-hover table-vcenter text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Pengarang</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Buku di troli akan dimuat di sini oleh DataTables -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Inisialisasi DataTable
        const table = $('#trolley-table').DataTable({
            ajax: {
                url: 'http://localhost:8080/books',
                dataSrc: function (json) {
                    // Filter hanya buku dengan status 'in trolley'
                    return json.filter(book => book.status === 'in trolley');
                },
                error: function (xhr, error, thrown) {
                    console.error('Gagal mengambil data buku:', error);
                }
            },
            columns: [
                { data: 'id' },
                { data: 'title' },
                { data: 'author' },
                { data: 'status' }
            ],
            responsive: true,
            pageLength: 10,
            language: {
                search: "Cari Buku:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Tidak ditemukan data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ buku",
                infoEmpty: "Tidak ada data tersedia",
                infoFiltered: "(difilter dari _MAX_ total data)"
            }
        });
    });
</script>

<?php $this->endSection(); ?>
