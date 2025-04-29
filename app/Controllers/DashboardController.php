<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\UserModel;

class DashboardController extends BaseController
{
    protected $productModel;
    protected $userModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->userModel = new UserModel();
    }

    // Menampilkan dashboard utama
    public function index()
    {
        if (session()->get('role') != 'staff') return redirect()->to('/login');

        // Ambil data untuk summary dashboard
        $data = [
            'total_staff' => $this->userModel->where('role', 'staff')->countAllResults(),
            'total_trolleys' => $this->userModel->where('role', 'trolley')->countAllResults(),
            'total_products' => $this->productModel->getTotalProducts(),
            'out_of_stock' => $this->productModel->getOutOfStockProducts(),
        ];
        return view('dashboard/index', $data);
    }

    // Menampilkan detail produk
    public function productDetails()
    {
        $data['products'] = $this->productModel->getProductDetails();

        return view('dashboard/product_details', $data);
    }
}
