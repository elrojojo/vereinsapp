<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Umfragen extends Migration
{
    public function up() {
        $this->forge->addField([
            'id'                => ['type' => 'int',        'constraint' => 11, 'unsigned' => true, 'null' => false,    'auto_increment' => true],
            'titel'             => ['type' => 'varchar',    'constraint' => 100,                    'null' => false],
            'status_auswahl'    => ['type' => 'varchar',    'constraint' => 50,                     'null' => false],
            'bemerkung'         => ['type' => 'varchar',    'constraint' => 100,                    'null' => false],
            'created_at'        => ['type' => 'datetime',                                           'null' => true],
            'updated_at'        => ['type' => 'datetime',                                           'null' => true],
            'deleted_at'        => ['type' => 'datetime',                                           'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('umfragen');

        $this->forge->addField([
            'id'            => ['type' => 'int',            'constraint' => 11, 'unsigned' => true, 'null' => false,    'auto_increment' => true],
            'umfrage_id'    => ['type' => 'int',            'constraint' => 11, 'unsigned' => true, 'null' => false],
            'mitglied_id'   => ['type' => 'int',            'constraint' => 11, 'unsigned' => true, 'null' => false],
            'status'        => ['type' => 'int',            'constraint' => 11, 'unsigned' => true, 'null' => false],
            'bemerkung'     => ['type' => 'varchar',        'constraint' => 100,                    'null' => true],
            'created_at'    => ['type' => 'datetime',                                               'null' => true],
            'updated_at'    => ['type' => 'datetime',                                               'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('umfrage_id');
        $this->forge->addForeignKey('umfrage_id', 'umfragen', 'id', '', 'CASCADE');
        $this->forge->addKey('mitglied_id');
        $this->forge->addForeignKey('mitglied_id', 'mitglieder', 'id', '', 'CASCADE');
        $this->forge->createTable('umfragen_rueckmeldungen');
            }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable('umfragen', true);
        $this->forge->dropTable('umfragen_rueckmeldungen', true);
        $this->db->enableForeignKeyChecks();
    }
}