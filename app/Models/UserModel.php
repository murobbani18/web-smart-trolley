<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'role'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Optionally, add validation rules here
    protected $validationRules = [
        'username' => 'required|is_unique[users.username]',
        'password' => 'required|min_length[8]',
        'role' => 'required|in_list[staff,pengguna]',
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'Username is required.',
            'is_unique' => 'This username is already taken.'
        ],
        'password' => [
            'required' => 'Password is required.',
            'min_length' => 'Password must be at least 8 characters long.'
        ],
        'role' => [
            'required' => 'Role is required.',
            'in_list' => 'Role must be either "staff" or "pengguna".'
        ]
    ];

    // Optionally, add a method for password verification
    public function verifyPassword($username, $password)
    {
        $user = $this->where('username', $username)->first();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    // New method: Get user by username
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }
}
