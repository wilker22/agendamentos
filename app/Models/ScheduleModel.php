<?php

namespace App\Models;

use App\Entities\Schedule;
use App\Entities\Service;
use Exception;

class ScheduleModel extends MyBaseModel
{
    protected $DBGroup          = 'default';
    protected $table            = 'schedules';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Schedule::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'unit_id',
        'service_id',
        'user_id',
        'finished',
        'canceled',
        'chosen_date',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    // Validation
    protected $validationRules      = []; // temos uma classe específica de validação


    protected $validationMessages   = [];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['escapeData', 'setUserId'];
    protected $beforeUpdate   = ['escapeData'];

    /**
     * Define no array de dados o id do usuário logado
     *
     * @param array $data
     * @return array
     */
    protected function setUserId(array $data): array
    {

        // o usuário está logado?
        if (!auth()->loggedIn()) {

            throw new Exception('Não existe uma sessão válida');
        }

        if (!isset($data['data'])) {

            return $data;
        }


        $data['data']['user_id'] = auth()->user()->id;

        return $data;
    }
}
