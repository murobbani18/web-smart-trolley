<?php
namespace App\Models;

use CodeIgniter\Model;

class TrolleyItemModel extends Model
{
    protected $table = 'trolley_items';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'item_id', 'quantity', 'rfid_code'];
    protected $useTimestamps = true;

    public function updateItemQuantity($itemId, $quantity)
    {
        return $this->where('item_id', $itemId)->set(['quantity' => $quantity])->update();
    }
}
