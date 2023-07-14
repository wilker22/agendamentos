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
                'type'           => 'VARCHAR',
                'constraint'     => 70,
            ],

            'email' => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
            ],

            'phone' => [
                'type'           => 'VARCHAR',
                'constraint'     => 14,
                'comment'        => '(99)99999-9999'
            ],

            'coordinator' => [
                'type'           => 'VARCHAR',
                'constraint'     => 70,
                'comment'        => 'Coordenador'
            ],

            'address' => [
                'type'           => 'VARCHAR',
                'constraint'     => 128,
                'comment'        => 'Endereço da unidade'
            ],

            'services' => [
                'type'           => 'JSON',
                'null'           => true,
                'default'        => null,
                'comment'        => 'Conterá os identificadores dos serviços. Exemplo: ["1", "2", "..."]'
            ],


            'starttime' => [
                'type'           => 'VARCHAR',
                'constraint'     => 6,
                'comment'        => 'Horário em que a unidade inicia o expediente. Esse valor é usado para calcular e exibir os horários
                                    disponíves da unidade. Exemplo: 08:00'
            ],

            'endtime' => [
                'type'           => 'VARCHAR',
                'constraint'     => 6,
                'comment'        => 'Horário em que a unidade finaliza o expediente. Esse valor é usado para calcular e exibir os horários
                                    disponíves da unidade. Exemplo: 18:00'
            ],

            'servicetime' => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
                'comment'        => 'Tempo necessário para cada atendimento. Exemplo: 1 hour, 10 minutes, 2 hours, '
            ],

            'active' => [
                'type'           => 'TINYINT',
                'constraint'     => 1,
                'default'        => 0,
                'comment'        => '0 => Não, 1 => Sim'
            ],


            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
                'default'        => null,
            ],

            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
                'default'        => null,
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
