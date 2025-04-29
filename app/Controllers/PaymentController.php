<?php

namespace App\Controllers;

use App\Models\PaymentModel;
use App\Models\BarangModel;
use CodeIgniter\Controller;

class PaymentController extends Controller
{
    protected $paymentModel;
    protected $barangModel;

    public function __construct()
    {
        $this->paymentModel = new PaymentModel();
        $this->barangModel = new BarangModel();
    }

    public function index()
    {
        $payments = $this->paymentModel->findAll();
        return view('payment/index', ['payments' => $payments]);
    }

    // Pengguna buat pembayaran
    public function create($barang_id)
    {
        $barang = $this->barangModel->find($barang_id);
        return view('payment/create', ['barang' => $barang]);
    }

    public function store()
    {
        $barangId = $this->request->getPost('barang_id');
        $jumlah = $this->request->getPost('jumlah');
        $namaPembeli = $this->request->getPost('nama_pembeli');
    
        $barang = $this->barangModel->find($barangId);
        $totalHarga = $barang['harga'] * $jumlah;
    
        $this->paymentModel->save([
            'user_id' => null,
            'barang_id' => $barangId,
            'jumlah' => $jumlah,
            'total_harga' => $totalHarga,
            'nama_pembeli' => $namaPembeli,
            'status' => 'pending'
        ]);
    
        return redirect()->to('/payment')->with('success', 'Pembayaran berhasil dibuat, menunggu validasi staff');
    }

    // Staff validasi pembayaran
    public function validatePayment($id)
    {
        $this->paymentModel->update($id, [
            'status' => 'validated',
            'validated_by' => session()->get('id')
        ]);

        return redirect()->to('/payment')->with('success', 'Pembayaran berhasil divalidasi');
    }

    public function rejectPayment($id)
    {
        $this->paymentModel->update($id, [
            'status' => 'rejected',
            'validated_by' => session()->get('id')
        ]);

        return redirect()->to('/payment')->with('success', 'Pembayaran ditolak');
    }
}
