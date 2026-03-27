<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditLogModel extends Model
{
    protected $table            = 'audit_logs';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'user_id',
        'username',
        'action',
        'entity_type',
        'entity_id',
        'subject',
        'description',
        'changes',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getRecentActivities(int $limit = 8): array
    {
        return $this->orderBy('created_at', 'DESC')
            ->findAll($limit);
    }
}
