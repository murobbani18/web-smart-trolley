<?php $this->extend('layout'); ?>

<?php $this->section('content'); ?>
<div class="container-xl">
    <h1 class="text-center mb-4">Katalog Buku</h1>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="book-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Pengarang</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="book-list">
                        <!-- Data buku akan dimuat disini -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBookModal">Tambah Buku</button>
</div>

<!-- Modal Tambah Buku -->
<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBookModalLabel">Tambah Buku</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addBookForm">
            <div class="mb-3">
                <label for="title" class="form-label">Judul</label>
                <input type="text" class="form-control" id="title" required>
            </div>
            <div class="mb-3">
                <label for="author" class="form-label">Pengarang</label>
                <input type="text" class="form-control" id="author" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" required>
                    <option value="Available">Tersedia</option>
                    <option value="In Trolley">Di Troli</option>
                    <option value="Borrowed">Dipinjam</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTable
        const table = $('#book-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/books',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success' && Array.isArray(response.data)) {
                        const books = response.data.map(function(book) {
                            return [
                                book.id,
                                book.title,
                                book.author,
                                `<span class="badge ${book.status === 'Available' ? 'bg-success' : 'bg-danger'}">${book.status}</span>`,
                                `
                                    <button class="btn btn-warning btn-sm" onclick="editBook(${book.id})">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteBook(${book.id})">Hapus</button>
                                `
                            ];
                        });

                        // Update data pada DataTable
                        table.clear().rows.add(books).draw();
                    } else {
                        console.error('Data tidak sesuai format yang diharapkan');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Gagal mengambil data buku:', error);
                }
            },
            columns: [
                { title: 'ID' },
                { title: 'Judul' },
                { title: 'Pengarang' },
                { title: 'Status' },
                { title: 'Aksi' }
            ]
        });

        // Fungsi untuk menambah buku menggunakan AJAX
        $('#addBookForm').submit(function(event) {
            event.preventDefault();
            
            const title = $('#title').val();
            const author = $('#author').val();
            const status = $('#status').val();

            // Cek nilai input
            console.log(title, author, status);

            $.ajax({
                url: '/books',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ title, author, status }),
                success: function(data) {
                    if (data.status === 'success') {
                        alert(data.message);
                        table.ajax.reload(); // Reload DataTable untuk menampilkan data terbaru
                    } else {
                        alert('Gagal menambahkan buku');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        });

        // Fungsi untuk menghapus buku menggunakan AJAX
        function deleteBook(id) {
            if (confirm('Apakah Anda yakin ingin menghapus buku ini?')) {
                $.ajax({
                    url: `/books/${id}`,
                    method: 'DELETE',
                    success: function(data) {
                        if (data.status === 'success') {
                            alert(data.message);
                            table.ajax.reload(); // Reload DataTable setelah penghapusan
                        } else {
                            alert('Gagal menghapus buku');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        }

        // Fungsi untuk mengedit buku (belum ada form edit)
        function editBook(id) {
            alert('Fitur edit belum tersedia');
        }
    });
</script>

<?php $this->endSection(); ?>
