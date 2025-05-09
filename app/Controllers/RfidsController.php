<?php

namespace App\Controllers;

use App\Models\RfidsModel;
use App\Models\ProductModel;
use App\Models\TrolleyItemModel;
use CodeIgniter\Controller;

class RfidsController extends Controller
{
    protected $RfidsModel;
    protected $productModel;
    protected $trolleyModel;

    public function __construct()
    {
        // Instance model
        $this->RfidsModel = new RfidsModel();
        $this->productModel = new ProductModel();
        $this->trolleyModel = new TrolleyItemModel();
    }

    // Fungsi untuk menyimpan produk dengan RFID (khusus untuk request dari NodeMCU)
    public function registerFromNodeMCU()
    {
        $data = [
            'item_id'   => $this->request->getVar('item_id'),
            'rfid_code' => $this->request->getVar('rfid_code'),
        ];
        log_message('error', 'Data yang diterima: ' . json_encode($data));

        // Insert data ke tabel item_rfids
        if ($this->RfidsModel->insert($data, false)) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Produk berhasil didaftarkan.',
            ]);
        } else {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Gagal mendaftarkan produk.',
            ]);
        }
    }

    // Fungsi untuk mencari produk berdasarkan RFID code
    public function scanProduct()
    {
        // Ambil data RFID code yang dikirim oleh NodeMCU
        $rfid_code = $this->request->getVar('rfid_code');

        // Cek apakah RFID code ada di database
        $rfid = $this->RfidsModel->where('rfid_code', $rfid_code)->first();

        if ($rfid) {
            // Produk ditemukan berdasarkan RFID code, cari produk berdasarkan item_id
            $product = $this->productModel->where('id', $rfid['item_id'])->first();

            if ($product) {
                // Mengembalikan informasi produk (nama dan harga) ke NodeMCU
                return $this->response->setJSON([
                    'status'  => 'success',
                    'message' => 'Produk ditemukan.',
                    'data'    => [
                        'name'  => $product['name'],  // Nama produk
                        'price' => $product['price'], // Harga produk
                    ],
                ]);
            } else {
                // Jika produk tidak ditemukan
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Produk tidak ditemukan di database produk.',
                ]);
            }
        } else {
            // Jika RFID code tidak ditemukan
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'RFID code tidak ditemukan.',
            ]);
        }
    }

    public function checkout()
    {
        $userId = 2;
        $trolleyModel = new \App\Models\TrolleyItemModel();
        $paymentModel = new \App\Models\PaymentModel();
        $paymentItemModel = new \App\Models\PaymentItemModel();
        $itemModel = new \App\Models\ProductModel();
    
        $trolleyItems = $trolleyModel
            ->select('trolley_items.*, items.stock, items.price')
            ->join('items', 'trolley_items.item_id = items.id')
            ->where('trolley_items.user_id', $userId)
            ->findAll();
    
        if (empty($trolleyItems)) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }
    
        $total = 0;
        foreach ($trolleyItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    
        // Simpan ke tabel payments
        $paymentId = $paymentModel->insert([
            'user_id'      => $userId,
            'total_amount' => $total
        ]);
    
        // Simpan detail item ke tabel payment_items
        foreach ($trolleyItems as $item) {
            $paymentItemModel->insert([
                'payment_id'       => $paymentId,
                'item_id'          => $item['item_id'],
                'quantity'         => $item['quantity'],
                'price_at_purchase'=> $item['price']
            ]);
    
            // Update stok di tabel items
            $itemModel->where('id', $item['item_id'])->decrement('stock', (int) $item['quantity']);
        }
    
        // Kosongkan keranjang
        $trolleyModel->where('user_id', $userId)->delete();
    }

    public function addProduct()
    {
        $rfid_checkout = ['d12345', 'd54321'];
        $rfid_code = $this->request->getVar('rfid_code');
        if (in_array($rfid_code, $rfid_checkout)) {
            $this->checkout();

            $response = [
                'status'  => 'success',
                'message' => 'Checkout berhasil',
            ];
        
            return $this->response->setJSON($response);
        } 

        // tambahkan ke keranjang
        $userId    = 2;
    
        $rfid = $this->RfidsModel->where('rfid_code', $rfid_code)->first();
        if (!$rfid) return $this->respondError('RFID code tidak ditemukan.');
    
        $product = $this->productModel->find($rfid['item_id']);
        if (!$product) return $this->respondError('Produk tidak ditemukan di database produk.');

        // $product = $this->productModel->find($rfid_code);
        // if (!$product) return $this->respondError('Produk tidak ditemukan di database produk.');
    
        $itemId = $product['id'];
    
        // Hapus jika RFID ini ada di trolley user lain
        $this->trolleyModel
            ->where('rfid_code', $rfid_code)
            ->where('user_id !=', $userId)
            ->delete();
    
        // Toggle: jika RFID ini sudah ada di trolley user ini, hapus
        $existing = $this->trolleyModel
            ->where('rfid_code', $rfid_code)
            ->where('user_id', $userId)
            ->first();
    
        if ($existing) {
            $this->trolleyModel
                ->where('rfid_code', $rfid_code)
                ->where('user_id', $userId)
                ->delete();
    
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Produk dihapus dari trolley.'
            ]);
        }
    
        // Simpan produk ke trolley
        $dataTrolley = [
            'user_id'   => $userId,
            'item_id'   => $itemId,
            'quantity'  => 1,
            'rfid_code' => $rfid_code
        ];
    
        if (!$this->trolleyModel->save($dataTrolley)) {
            return $this->respondError('Gagal menambahkan produk ke trolley.');
        }
    
        $response = [
            'status'  => 'success',
            'message' => 'Produk ditambahkan ke trolley.',
            'data'    => [
                'name'  => $product['name'],
                'price' => $product['price']
            ]
        ];
    
        log_message('error', 'Produk berhasil ditambahkan ke trolley: ' . json_encode($response));
        return $this->response->setJSON($response);
    }
    
    public function payments()
    {
        $userId = 2;
        // $userId = $this->request->getVar('user_id');
    
        // Instance models
        $trolleyModel = new \App\Models\TrolleyItemModel();
        $paymentModel = new \App\Models\PaymentModel();
        $itemModel    = new \App\Models\ProductModel();
    
        // Get items in the trolley
        $trolleyItems = $trolleyModel
            ->select('trolley_items.*, items.price')
            ->join('items', 'trolley_items.item_id = items.id')
            ->where('trolley_items.user_id', $userId)
            ->findAll();
    
        if (empty($trolleyItems)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'lcd'     => 'Trolley Kosong', 
                'message' => 'Keranjang kosong.'
            ]);
        }
    
        // Calculate total price
        $total = array_sum(array_column($trolleyItems, 'price'));
    
        // Insert payment record
        $paymentId = $paymentModel->insert([
            'user_id'      => $userId,
            'total_amount' => $total
        ]);
    
        // Update stock and remove items from trolley
        foreach ($trolleyItems as $item) {
            $itemModel->where('id', $item['item_id'])->decrement('stock', 1);
        }
        $trolleyModel->where('user_id', $userId)->delete();
    
        // Prepare LCD display text
        $lcdText = "Bayar Sukses\nTotal: Rp" . number_format($total, 0, ',', '.');
    
        return $this->response->setJSON([
            'status'     => 'success',
            'message'    => 'Pembayaran berhasil.',
            'payment_id' => $paymentId,
            'total'      => $total,
            'lcd'        => $lcdText
        ]);
    }

    private function respondError($message)
    {
        $response = [
            'status'  => 'error',
            'message' => $message
        ];
    
        log_message('error', $message);
        return $this->response->setJSON($response);
    }
}
