<?php //php spark make:migration AddCustomColumnForUser

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Extend_User extends Migration
{
    public function up()
    {
        $fields = [
            'vorname' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'nachname' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'geburt' => [
                'type'       => 'DATETIME',
                'null'       => TRUE,
            ],
            'postleitzahl' => [
                'type'       => 'INT',
                'constraint' => '5',
            ],
            'wohnort' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'geschlecht' => [
                'type'       => 'VARCHAR',
                'constraint' => '5',
                'default' => 'd',
            ],
            'register' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'funktion' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'vorstandschaft' => [
                'type'       => 'INT',
                'constraint' => '1',
                'default' => '0',
            ],
            'aktiv' => [
                'type'       => 'INT',
                'constraint' => '1',
                'default' => '1',
            ],
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $fields = [
            'vorname',
            'nachname',
            'geburt',
            'postleitzahl',
            'wohnort',
            'geschlecht',
            'register',
            'funktion',
            'vorstandschaft',
            'aktiv',
        ];
        $this->forge->dropColumn('users', $fields);
    }
}
