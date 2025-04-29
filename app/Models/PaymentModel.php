<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'barang_id', 'jumlah', 'total_harga', 'nama_pembeli', 'bukti_bayar', 'status', 'validated_by'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Optionally, you can define relations here
    protected $validationRules = [
        'user_id' => 'required|integer',
        'barang_id' => 'required|integer',
        'jumlah' => 'required|integer',
        'total_harga' => 'required|decimal',
        'nama_pembeli' => 'required|string|max_length[255]',
        'status' => 'in_list[pending,validated,rejected]',
    ];

    // Optionally, add relation methods (e.g., getting user and item details)
    public function getPaymentDetails($id)
    {
        return $this->select('payments.*, users.username as user, barangs.nama_barang')
                    ->join('users', 'users.id = payments.user_id', 'left')
                    ->join('barangs', 'barangs.id = payments.barang_id', 'left')
                    ->where('payments.id', $id)
                    ->first();
    }
}
