<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Extend_Mitglieder extends Migration
{
    public function up() {
        $this->forge->addColumn('mitglieder', [
            'vorname'       => ['type' => 'varchar',    'constraint' => 50,                         'null' => false],
            'nachname'      => ['type' => 'varchar',    'constraint' => 50,                         'null' => false],
            'geburt'        => ['type' => 'datetime',                                               'null' => false],
            'postleitzahl'  => ['type' => 'int',        'constraint' => 5,                          'null' => false],
            'wohnort'       => ['type' => 'varchar',    'constraint' => 50,                         'null' => false],
            'geschlecht'    => ['type' => 'varchar',    'constraint' => 5,                          'null' => false,    'default' => 'd'],
            'register'      => ['type' => 'varchar',    'constraint' => 50,                         'null' => false],
            'funktion'      => ['type' => 'varchar',    'constraint' => 50,                         'null' => false],
            'vorstandschaft'=> ['type' => 'int',        'constraint' => 1,                          'null' => false,    'default' => 0],
            'aktiv'         => ['type' => 'int',        'constraint' => 1,                          'null' => false,    'default' => 1],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('mitglieder', [
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
        ]);
    }
}