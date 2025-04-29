<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('index');
    }

    public function dashboard()
    {
        if (session()->get('role') != 'admin' && session()->get('role') != 'staff') {
            return redirect()->to('/login');
        }

        // Lanjutkan dengan tampilan dashboard jika staff/admin
        return view('dashboard');
    }

}
