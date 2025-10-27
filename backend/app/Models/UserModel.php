<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'email', 'password_hash', 'employee_type', 'status'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'name'          => 'required|max_length[120]',
        'email'         => 'required|valid_email|max_length[190]',
        'password_hash' => 'required|max_length[255]',
        // Model accepts only staff/manager for general inserts/updates.
        // The single 'admin' account is created via seeder, not via UI.
        'employee_type' => 'required|in_list[staff,manager]',
        'status'        => 'required|in_list[active,inactive]',
    ];
}
