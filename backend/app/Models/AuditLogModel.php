<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditLogModel extends Model
{
    protected $table = 'audit_logs';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'actor_user_id',
        'action',
        'entity_type',
        'entity_id',
        'details',
        'created_at'
    ];
    public $useTimestamps = false;
}
