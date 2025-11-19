<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table = 'carts';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['customer_id', 'status'];
    protected $validationRules = [
        'customer_id' => 'required|is_natural_no_zero',
        'status' => 'required|in_list[active,checked_out]',
    ];
}
