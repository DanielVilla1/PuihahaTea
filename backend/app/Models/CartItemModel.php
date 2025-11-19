<?php

namespace App\Models;

use CodeIgniter\Model;

class CartItemModel extends Model
{
    protected $table = 'cart_items';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['cart_id', 'product_id', 'quantity', 'unit_price'];
    protected $validationRules = [
        'cart_id' => 'required|is_natural_no_zero',
        'product_id' => 'required|is_natural_no_zero',
        'quantity' => 'required|is_natural_no_zero',
        'unit_price' => 'required|decimal',
    ];
}
