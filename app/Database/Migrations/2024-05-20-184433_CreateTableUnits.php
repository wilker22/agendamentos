<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableUnits extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'phone' => [
                'type' => 'VARCHAR',
                'constraint' => 14,
                'comment' => '(99)99999-9999'
            ],
            'coordinator' => [
                'type' => 'TEXT',
                'constraint' => 100,
                'comment' => 'Coordenador'
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'comment' => 'endereço da unidade'
            ],
            'services' => [
                'type' => 'JSON',
                'null' => true,
                'default' => null,
                'comment' => 'Conterá os identificadores dos serviços'
            ],
            'starttime' => [
                'type' => 'VARCHAR',
                'constraint' => 6,
                'comment' => 'Horário de abertura da Unidade'
            ],
            'endtime' => [
                'type' => 'VARCHAR',
                'constraint' => 6,
                'comment' => 'Horário de fechamento da Unidade'
            ],
            'servicetime' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'comment' => 'tempo de execução do serviço'
            ],
            'active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,

            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,


            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,


            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('name');
        $this->forge->addKey('email');
        $this->forge->addKey('phone');
        $this->forge->createTable('units');
    }

    public function down()
    {
        $this->forge->dropTable('units');
    }
}
