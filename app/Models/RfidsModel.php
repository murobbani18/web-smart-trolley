<?php
namespace App\Models;

use CodeIgniter\Model;

class RfidsModel extends Model
{
    protected $table = 'item_rfids';
    protected $primaryKey = 'id';
    protected $allowedFields = ['item_id', 'rfid_code'];
    protected $useTimestamps = true;
}
