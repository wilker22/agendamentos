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


    /**
     * Verifica se a data e horário escolhidos não estão agendados. 
     * Útil para fazer um último 'check' antes de inserir o registro, pois o usuário pode ficar com a página aberta por bastante tempo.
     *
     * @param integer|string $unitId
     * @param string $chosenDate
     * @return boolean
     */
    public function chosenDateIsFree(int|string $unitId, string $chosenDate): bool
    {

        return $this->where('unit_id', $unitId)->where('chosen_date', $chosenDate)->first() === null;
    }


    /**
     * Recupera o agendamento de acordo com o id
     *
     * @param integer|string $id
     * @return Schedule
     */
    public function getSchedule(int|string $id): Schedule
    {

        $this->select([
            'schedules.*',
            'units.name AS unit',
            'units.address',
            'services.name AS service',
        ]);

        $this->join('units', 'units.id = schedules.unit_id');
        $this->join('services', 'services.id = schedules.service_id');

        return $this->findOrFail($id);
    }
}
