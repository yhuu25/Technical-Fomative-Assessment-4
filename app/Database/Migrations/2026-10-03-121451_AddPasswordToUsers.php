<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPasswordToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
        ]);

        $users = $this->db->table('users')->get()->getResultArray();

        foreach ($users as $user) {
            $this->db->table('users')
                ->where('id', $user['id'])
                ->update([
                    'password' => password_hash(
                        'password123',
                        PASSWORD_DEFAULT
                    ),
                ]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'password');
    }
}