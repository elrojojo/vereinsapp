<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Notenbank extends Migration
{
    public function up() {
        $this->forge->addField([
            'id'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'titel'         => ['type' => 'varchar', 'constraint' => 100, 'null' => false],
            'titel_nr'      => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'kategorie'     => ['type' => 'varchar', 'constraint' => 50, 'null' => false],
            'created_at'    => ['type' => 'datetime', 'null' => true],
            'updated_at'    => ['type' => 'datetime', 'null' => true],
            'deleted_at'    => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('notenbank');
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable('notenbank', true);
        $this->db->enableForeignKeyChecks();    }
}
