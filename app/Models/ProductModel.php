<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'items'; // Nama tabel produk
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'price', 'stock', 'rfid_code', 'rack_code', 'position_detail', 'description', 'image'];

    // Mendapatkan total produk
    public function getTotalProducts()
    {
        return $this->countAllResults();
    }

    // Mendapatkan stok habis
    public function getOutOfStockProducts()
    {
        return $this->where('stock', 0)->findAll();
    }

    // Mendapatkan produk berdasarkan kategori atau parameter tertentu
    public function getProductDetails()
    {
        return $this->findAll();
    }
}
