<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth/login');
    }

    public function loginPost()
    {
        $model = new UserModel();
        $data = [
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password')
        ];

        $user = $model->getUserByUsername($data['username']);

        if ($user && password_verify($data['password'], $user['password'])) {
            // Set session untuk login
            session()->set([
                'isLoggedIn' => true,
                'user_id'    => $user['id'],
                'username'   => $user['username'],
                'role'       => $user['role']
            ]);

            // Redirect berdasarkan role
            if ($user['role'] == 'admin' || $user['role'] == 'staff') {
                return redirect()->to('/dashboard');
            } else {
                return redirect()->to('/catalog'); // Pengguna biasa
            }
        } else {
            return redirect()->back()->with('error', 'Username atau password salah.');
        }
    }

    public function logout()
    {
        session()->remove('isLoggedIn');
        session()->remove('user_id');
        session()->remove('username');
        session()->remove('role');

        return redirect()->to('/login');
    }

    // Fungsi untuk menampilkan halaman register
    public function register()
    {
        return view('auth/register');
    }

    // Fungsi untuk menangani proses registrasi
    public function registerPost()
    {
        $model = new UserModel();
        $password = $this->request->getPost('password');
        $confirmPassword = $this->request->getPost('confirm_password');
        $role = $this->request->getPost('role');
    
        // Validasi password konfirmasi
        if ($password !== $confirmPassword) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak cocok.');
        }
    
        // Validasi role harus dipilih
        if (empty($role)) {
            return redirect()->back()->with('error', 'Role harus dipilih.');
        }
    
        $data = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'role'     => $role,
        ];
    
        // Cek jika username sudah ada
        $existingUser = $model->getUserByUsername($data['username']);
        if ($existingUser) {
            return redirect()->back()->with('error', 'Username sudah terdaftar.');
        }
    
        // Simpan data user baru
        $model->save($data);
    
        return redirect()->to('/login')->with('success', 'Registrasi berhasil, silakan login.');
    }
}
