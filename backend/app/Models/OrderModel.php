<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'customer_name',
        'items',
        'status',
        'assigned_to',
        'total',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'customer_name' => 'permit_empty|max_length[120]',
        'items'         => 'permit_empty',
        'status'        => 'required|in_list[pending,brewing,ready,delivered,cancelled]',
        'assigned_to'   => 'permit_empty|is_natural',
        'total'         => 'permit_empty|decimal',
    ];
}
