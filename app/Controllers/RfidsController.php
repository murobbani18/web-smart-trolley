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

    // Fungsi untuk mencari produk berdasarkan RFID code dan menambahkannya ke trolley
    public function addProduct()
    {
        // Ambil data RFID code yang dikirim oleh NodeMCU
        $rfid_code = $this->request->getVar('rfid_code');

        // Cek apakah RFID code ada di database
        $rfid = $this->RfidsModel->where('rfid_code', $rfid_code)->first();

        if ($rfid) {
            // Produk ditemukan berdasarkan RFID code, cari produk berdasarkan item_id
            $product = $this->productModel->where('id', $rfid['item_id'])->first();

            if ($product) {
                $dataTrolley = [
                    'user_id'  => 2,
                    'item_id'  => $product['id'],
                    'quantity' => 1
                ];

                // Menyimpan data trolley
                if ($this->trolleyModel->save($dataTrolley)) {
                    // Jika berhasil menyimpan data ke tabel trolley, return success
                    $response = [
                        'status'  => 'success',
                        'message' => 'Produk ditambahkan.',
                        'data'    => [
                            'name'  => $product['name'],  // Nama produk
                            'price' => $product['price'], // Harga produk
                        ],
                    ];

                    // Log response untuk debug
                    log_message('error', 'Produk berhasil ditambahkan ke trolley: ' . json_encode($response));

                    return $this->response->setJSON($response);
                } else {
                    // Jika gagal menyimpan data ke trolley
                    $response = [
                        'status'  => 'error',
                        'message' => 'Gagal menambahkan produk ke trolley.',
                    ];

                    // Log response error
                    log_message('error', 'Gagal menambahkan produk ke trolley: ' . json_encode($response));

                    return $this->response->setJSON($response);
                }
            } else {
                // Jika produk tidak ditemukan di database produk
                $response = [
                    'status'  => 'error',
                    'message' => 'Produk tidak ditemukan di database produk.',
                ];

                // Log response error
                log_message('error', 'Produk tidak ditemukan di database produk: ' . json_encode($response));

                return $this->response->setJSON($response);
            }
        } else {
            // Jika RFID code tidak ditemukan
            $response = [
                'status'  => 'error',
                'message' => 'RFID code tidak ditemukan.',
            ];

            // Log response error
            log_message('error', 'RFID code tidak ditemukan: ' . json_encode($response));

            return $this->response->setJSON($response);
        }
    }
}
