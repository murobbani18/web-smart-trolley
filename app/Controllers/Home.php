<?php

namespace App\Controllers;
use App\Models\ProductModel;

class Home extends BaseController
{
    public function index()
    {
        return redirect()->to('/dashboard');
        // return view('dashboard/index');
    }

    public function dashboard()
    {
        if (session()->get('role') != 'admin' && session()->get('role') != 'staff') {
            return redirect()->to('/login');
        }

        // Lanjutkan dengan tampilan dashboard jika staff/admin
        return view('dashboard/index');
    }
    
    public function katalog()
    {
        $itemModel = new ProductModel();
        $items = $itemModel->findAll();
        return view('katalog/index', ['items' => $items]);
    }
}
