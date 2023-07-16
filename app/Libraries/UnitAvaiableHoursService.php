<?php

namespace App\Libraries;

use App\Models\UnitModel;
use CodeIgniter\I18n\Time;

class UnitAvaiableHoursService
{

    /**
     * Renderiza as horas disponíves para serem escolhidas no agendamento.
     *
     * @param array $request
     * @return string|null
     */
    public function renderHours(array $request): string|null
    {

        // transformo em objeto
        $request = (object) $request;

        // precisamo obter a unidade, mes e dia desejados
        $unitId = (string) $request->unit_id;
        $month  = (string) $request->month;
        $day    = (string) $request->day;

        // adicionamos um zero à esquerda do mes e dia, quando for o caso
        $month = strlen($month) < 2 ? sprintf("%02d", $month) : $month;
        $day   = strlen($day) < 2 ? sprintf("%02d", $day) : $day;

        // validamos a existência da unidade, ativa, com serviços
        $unit = model(UnitModel::class)->where(['active' => 1, 'services !=' => null, 'services !=' => ''])->findOrFail($unitId);

        // data atual
        $now = Time::now();

        // obtemos a data desejada
        // terei algo assim: 2023-07-16
        $dateWanted = "{$now->getYear()}-{$month}-{$day}";

        /**
         * @todo quando estivermos criando agendamentos, precisamos buscar os agendamentos já realizados para a a unidade em questão
         */

        // precisamo identificar se a data desejada é a data atual
        $isCurrentDay = $dateWanted === $now->format('Y-m-d');
    }
}
