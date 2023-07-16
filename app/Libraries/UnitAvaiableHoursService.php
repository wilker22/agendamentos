<?php

namespace App\Libraries;

use App\Models\UnitModel;
use CodeIgniter\I18n\Time;
use DateInterval;
use DatePeriod;

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

        try {

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


            // criamos o range de horários
        } catch (\Throwable $th) {


            log_message('error', '[ERROR] {exception}', ['exception' => $th]);

            return "Não foi possível recuperar os horários disponíveis";
        }
    }


    /**
     * Cria um array com range de horários de acordo com início, fim e intervalo.
     *
     * @param string $start
     * @param string $end
     * @param string $interval
     * @param boolean $isCurrentDay
     * @return array
     */
    private function createUnitTimeRange(string $start, string $end,  string $interval, bool $isCurrentDay): array
    {

        $period = new DatePeriod(
            new Time($start),
            DateInterval::createFromDateString($interval),
            new Time($end)
        );
    }
}
