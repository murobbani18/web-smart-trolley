<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentItemModel extends Model
{
    protected $table = 'payment_items';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'payment_id', 'item_id', 'quantity', 'price_at_purchase'
    ];
}
