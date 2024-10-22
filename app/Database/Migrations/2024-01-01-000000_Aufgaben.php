<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Aufgaben extends Migration
{
    public function up() {
        $this->forge->addField([
            'id'                    => ['type' => 'int',        'constraint' => 11,     'unsigned' => true, 'null' => false,    'auto_increment' => true],
            'liste'                 => ['type' => 'varchar',    'constraint' => 50,                         'null' => true],
            'element_id'            => ['type' => 'int',        'constraint' => 11,     'unsigned' => true, 'null' => true],
            'titel'                 => ['type' => 'varchar',    'constraint' => 100,                        'null' => false],
            'mitglied_id_eingeplant'   => ['type' => 'int',        'constraint' => 11,     'unsigned' => true, 'null' => false],
            'mitglied_id_erledigt'  => ['type' => 'int',        'constraint' => 11,     'unsigned' => true, 'null' => true],
            'zeitpunkt_erledigt'    => ['type' => 'datetime',                                               'null' => true],
            'bemerkung'             => ['type' => 'varchar',    'constraint' => 100,                        'null' => false],
            'created_at'            => ['type' => 'datetime',                                               'null' => true],
            'updated_at'            => ['type' => 'datetime',                                               'null' => true],
            'deleted_at'            => ['type' => 'datetime',                                               'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('mitglied_id');
        $this->forge->addForeignKey('mitglied_id_eingeplant', 'mitglieder', 'id', '', 'CASCADE');
        $this->forge->addForeignKey('mitglied_id_erledigt', 'mitglieder', 'id', '', 'CASCADE');
        $this->forge->createTable('aufgaben');
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable('aufgaben', true);
        $this->db->enableForeignKeyChecks();
    }
}