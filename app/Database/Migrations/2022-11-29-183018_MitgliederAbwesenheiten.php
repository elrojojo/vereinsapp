<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MitgliederAbwesenheiten extends Migration
{
    public function up() {
        $this->forge->addField([
            'id'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'mitglied_id'   => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => false],
            'start'         => ['type' => 'datetime', 'null' => false],
            'ende'          => ['type' => 'datetime', 'null' => false],
            'bemerkung'     => ['type' => 'varchar', 'constraint' => 100, 'null' => true],
            'created_at'    => ['type' => 'datetime', 'null' => true],
            'updated_at'    => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('mitglied_id');
        $this->forge->addForeignKey('mitglied_id', 'users', 'id', '', 'CASCADE');
        $this->forge->createTable('mitglieder_abwesenheiten');
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable('mitglieder_abwesenheiten', true);
        $this->db->enableForeignKeyChecks();    }
}
