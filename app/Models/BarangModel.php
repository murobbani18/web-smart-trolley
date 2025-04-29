<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table            = 'barangs';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nama_barang', 'harga', 'stok', 'posisi_rak'];
    protected $useTimestamps    = true;
}
