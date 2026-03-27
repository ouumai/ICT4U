<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameAuditLogUserNameColumn extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('audit_logs')) {
            return;
        }

        $fields = $this->db->getFieldData('audit_logs');
        $hasUserName = false;
        $hasUsername = false;

        foreach ($fields as $field) {
            if ($field->name === 'user_name') {
                $hasUserName = true;
            }

            if ($field->name === 'username') {
                $hasUsername = true;
            }
        }

        if ($hasUserName && ! $hasUsername) {
            $this->forge->modifyColumn('audit_logs', [
                'user_name' => [
                    'name'       => 'username',
                    'type'       => 'VARCHAR',
                    'constraint' => 150,
                    'null'       => true,
                ],
            ]);
        }
    }

    public function down()
    {
        if (! $this->db->tableExists('audit_logs')) {
            return;
        }

        $fields = $this->db->getFieldData('audit_logs');
        $hasUserName = false;
        $hasUsername = false;

        foreach ($fields as $field) {
            if ($field->name === 'user_name') {
                $hasUserName = true;
            }

            if ($field->name === 'username') {
                $hasUsername = true;
            }
        }

        if ($hasUsername && ! $hasUserName) {
            $this->forge->modifyColumn('audit_logs', [
                'username' => [
                    'name'       => 'user_name',
                    'type'       => 'VARCHAR',
                    'constraint' => 150,
                    'null'       => true,
                ],
            ]);
        }
    }
}
