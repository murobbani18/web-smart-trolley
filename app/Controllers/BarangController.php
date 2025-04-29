<?php

namespace App\Controllers;

use App\Models\BarangModel;

class BarangController extends BaseController
{
    public function index()
    {
        // Untuk menampilkan daftar barang bagi pengunjung
        $barangModel = new BarangModel();
        $data['barang'] = $barangModel->findAll();
        
        return view('barang/index', $data);
    }

    public function manage()
    {
        // Untuk mengelola barang (staff)
        $barangModel = new BarangModel();
        $data['barang'] = $barangModel->findAll();
        
        return view('barang/manage', $data);
    }

    public function edit($id)
    {
        // Halaman edit barang (staff)
        $barangModel = new BarangModel();
        $data['barang'] = $barangModel->find($id);
        
        return view('barang/edit', $data);
    }

    public function update($id)
    {
        // Proses update barang (staff)
        $barangModel = new BarangModel();
        
        $data = [
            'nama' => $this->request->getPost('nama'),
            'harga' => $this->request->getPost('harga'),
            'stok' => $this->request->getPost('stok')
        ];

        $barangModel->update($id, $data);
        return redirect()->to('/barang/manage');
    }
}
