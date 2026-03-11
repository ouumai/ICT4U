<?php

namespace App\Models;

use CodeIgniter\Shield\Models\UserModel as ShieldUserModel;

class UserModel extends ShieldUserModel
{
    protected $table          = 'users';
    protected $primaryKey     = 'id';
    
    // Kemaskini allowedFields: Ikut column dalam database Mai + profile_pic
    protected $allowedFields  = [
        'fullname', 
        'status', 
        'status_message', 
        'active', 
        'last_active', 
        'profile_pic',
        'created_at', 
        'updated_at',
        'deleted_at'
    ];
    
    // double hash
    /*
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
    */
}