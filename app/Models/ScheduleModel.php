<?php

namespace App\Models;

use App\Entities\Schedule;
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


    /**
     * Recupera os agendamentos não finalizados de acordo com a unidade.
     *
     * @param integer|string $unitId
     * @param string $dateWanted Exemplo: 2023-11-29
     * @return array horas. Exemplo: ['07:00', '07:30', 'HH:ss', etc]
     */
    public function getScheduledHoursByDate(int|string $unitId, string $dateWanted): array
    {

        $this->select('DATE_FORMAT(chosen_date, "%H:%i") AS hour'); // terei: 15:10
        $this->where('unit_id', $unitId);
        $this->where('finished', 0); // agendamento em aberto
        $this->where('DATE_FORMAT(chosen_date, "%Y-%m-%d")', $dateWanted); // apenas de acordo com a data desejada

        $result = $this->findAll();

        if (empty($result)) {

            return [];
        }

        return array_column($result, 'hour'); // ['07:00', '07:30', 'HH:ss', etc]
    }


    /**
     * Recupera os agendamentos do usuário logado.
     *
     * @return array
     */
    public function getLoggedUserSchedules(): array
    {
        if (!auth()->loggedIn()) {

            return [];
        }

        $this->select([
            'schedules.*',
            'DATE_FORMAT(schedules.chosen_date, "%d/%m/%Y às %H:%i") AS formated_chosen_date', // 23/03/2023 às 15:15
            'units.name AS unit',
            'units.address',
            'services.name AS service',
        ]);

        $this->join('units', 'units.id = schedules.unit_id');
        $this->join('services', 'services.id = schedules.service_id');
        $this->where('schedules.user_id', auth()->user()->id); // do user logado
        $this->orderBy('schedules.id', 'DESC');

        return $this->findAll();
    }
}
