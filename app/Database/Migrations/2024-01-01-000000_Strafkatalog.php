<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Strafkatalog extends Migration
{
    public function up() {
        $this->forge->addField([
            'id'                 => ['type' => 'int',       'constraint' => 11,     'unsigned' => true, 'null' => false,    'auto_increment' => true],
            'titel'              => ['type' => 'varchar',   'constraint' => 100,                        'null' => false],
            'wert'               => ['type' => 'decimal',   'constraint' => '10,2', 'unsigned' => true, 'null' => false,    'default' => '0.00'],
            'kategorie'          => ['type' => 'varchar',   'constraint' => 50,                         'null' => false],
            'bemerkung'          => ['type' => 'varchar',   'constraint' => 100,                        'null' => true],
            'created_at'         => ['type' => 'datetime',                                              'null' => true],
            'updated_at'         => ['type' => 'datetime',                                              'null' => true],
            'deleted_at'         => ['type' => 'datetime',                                              'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('strafkatalog');
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable('strafkatalog', true);
        $this->db->enableForeignKeyChecks();
    }
}