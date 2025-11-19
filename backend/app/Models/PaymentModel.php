<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['order_id', 'method', 'amount', 'status', 'reference'];
    protected $validationRules = [
        'order_id' => 'required|is_natural_no_zero',
        'method' => 'required|in_list[credit,debit,ebank]',
        'amount' => 'required|decimal',
        'status' => 'required|in_list[simulated,failed]',
    ];
}
