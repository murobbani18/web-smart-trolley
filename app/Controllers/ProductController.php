<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\RfidsModel;

class ProductController extends BaseController
{
    protected $productModel;
    protected $locationModel;
    protected $rfidModel;
    
    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->rfidModel = new RfidsModel();
    }

    // List semua produk
    public function index()
    {
        $data['products'] = $this->productModel->findAll();

        foreach($data['products'] as &$product) {
            $product['rfids'] = $this->rfidModel->where('item_id', $product['id'])->findAll();
        }

        return view('products/index', $data);
    }

    // ProductController.php
    public function detail($id)
    {
        // Ambil data produk berdasarkan ID
        $product = $this->productModel->find($id);

        $product['rfids'] = $this->rfidModel->where('item_id', $product['id'])->findAll();

        // Kirim data ke view
        return view('products/detail', [
            'product' => $product
        ]);
    }
    
    // Form tambah produk
    public function create()
    {
        return view('products/create');
    }

    // Simpan produk baru
    public function store()
    {

        // Ambil file gambar dari form
        $imageFile = $this->request->getFile('image');
        $imageName = '';

        // Periksa apakah ada file yang diupload dan file valid
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            // Validasi ekstensi file gambar
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($imageFile->getMimeType(), $allowedTypes)) {
                // Set nama file gambar yang acak
                $imageName = $imageFile->getRandomName();

                // Pindahkan gambar ke folder 'uploads/'
                $imageFile->move('uploads/', $imageName);
            } else {
                // Jika tipe file tidak valid, kirim pesan error
                return redirect()->back()->with('error', 'Hanya file gambar yang diperbolehkan (JPEG, PNG, GIF).');
            }
        } else {
            // Jika tidak ada gambar yang diupload
            return redirect()->back()->with('error', 'Gambar produk tidak valid atau gagal diupload.');
        }


        $parsedRfidCode = json_decode($this->request->getPost('rfid_code'), true);

        // Simpan data produk di database
        $productId = $this->productModel->insert([
            'name'        => $this->request->getPost('name'),
            'price'       => $this->request->getPost('price'),
            'stock'       => count($parsedRfidCode),
            'description' => $this->request->getPost('description'),
            'image'       => $imageName, // Simpan nama file gambar
            'position_detail' => $this->request->getPost('position_detail'),
            'rack_code' => $this->request->getPost('rack_code'),
            'rfid_code' => $this->request->getPost('rfid_code'),
        ]);
        
        foreach($parsedRfidCode as $rfid) {
            $this->rfidModel->save([
                'rfid_code' => $rfid["value"],
                'item_id' => $productId // nilai nya masih 0
            ]);
        }

        // echo ENVIRONMENT;
        // exit();
        // Redirect ke halaman produk dengan pesan sukses
        return redirect()->to('/products')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Form edit
    public function edit($id)
    {
        $data['product'] = $this->productModel->find($id);

        $data['product']['rfids'] = $this->rfidModel->where('item_id', $data['product']['id'])->findAll();

        return view('products/edit', $data);
    }

    // Simpan perubahan
    public function update($id)
    {
        $data = [
            'name'        => $this->request->getPost('name'),
            'price'       => $this->request->getPost('price'),
            'stock'       => $this->request->getPost('stock'),
            'description' => $this->request->getPost('description'),
            'position_detail' => $this->request->getPost('position_detail'),
            'rack_code' => $this->request->getPost('rack_code'),
            'rfid_code' => $this->request->getPost('rfid_code'),
        ];
    
        $imageFile = $this->request->getFile('image');
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $imageName = $imageFile->getRandomName();
            $imageFile->move('uploads/', $imageName);
            $data['image'] = $imageName;
        }


        $parsedRfidCode = json_decode($this->request->getPost('rfid_code'), true);

        $editParsedRFIDCODE = [];
        foreach ($parsedRfidCode as $rfid) {
            $editParsedRFIDCODE[] = $rfid["value"];
        }

        $rfids = $this->rfidModel->where('item_id', $id)->findAll();
        $existsRFIDS = [];
        foreach ($rfids as $rfid) {
            $existsRFIDS[] = $rfid['rfid_code'];
        }

        // delete rfid item jika tidak ada pada request 
        foreach ($existsRFIDS as $rfid) {
            if (!in_array($rfid, $editParsedRFIDCODE)) {
                $this->rfidModel->where('rfid_code', $rfid)->where('item_id', $id)->delete();
            }
        }

        // insert ke rfid item jika pada request tersebut tidak terdaftar pada rfid exists
        foreach ($editParsedRFIDCODE as $rfid) {
            if (!in_array($rfid, $existsRFIDS)) {
                $this->rfidModel->save([
                    'rfid_code' => $rfid,
                    'item_id' => $id // nilai nya masih 0
                ]);
            }
        }

        $this->productModel->update($id, $data);
    
        return redirect()->to('/products')->with('success', 'Produk berhasil diperbarui!');
    }
    
    // Hapus produk
    public function delete($id)
    {
        // Ambil data produk berdasarkan ID
        $product = $this->productModel->find($id);
    
        // Periksa apakah produk memiliki gambar dan file gambarnya ada
        if ($product && $product['image']) {
            $imagePath = 'uploads/' . $product['image'];
    
            // Hapus file gambar jika ada
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
   
        // Hapus rfid yang berelasi dengan produk ini
        $this->rfidModel->where('item_id', $id)->delete();
        
        // Hapus data produk dari database
        $this->productModel->delete($id);
    
        // Redirect dengan pesan sukses
        return redirect()->to('/products')->with('success', 'Produk berhasil dihapus!');
    }
}
