<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;

    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'account_number',
        'name',
        'address',
        'email',
        'cellphone',
        'status',
        'password_hash',
        'verification_token',
        'token_sent_at',
        'verified_at',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'account_number' => 'required|min_length[3]|max_length[32]',
        'name'           => 'required|min_length[2]|max_length[120]',
        'email'          => 'required|valid_email|max_length[190]',
        'cellphone'      => 'permit_empty|max_length[32]',
        'status'         => 'in_list[regular,vip,guest]',
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;
}
