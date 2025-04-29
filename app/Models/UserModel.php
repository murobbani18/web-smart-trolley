<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'role'];

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
