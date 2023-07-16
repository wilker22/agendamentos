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

            $timeRange = $this->createUnitTimeRange(
                start: $unit->starttime,
                end: $unit->endtime,
                interval: $unit->servicetime,
                isCurrentDay: $isCurrentDay
            );


            // abertura da div com os horários com valor padrão null
            $divHours = null;

            foreach ($timeRange as $hour) {

                /**
                 * @todo verificar se o horário já não existe na tabela de agendamentos
                 */

                $divHours .= form_button(data: ['class' => 'btn btn-hour btn-primary', 'data-hour' => $hour], content: $hour);
            }

            // finalmente retornamos o range de horários
            return $divHours;
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

        // receberá os tempos gerados
        $timeRange = [];

        // tempo atual em hh:mm para comparar com a hora e minutos gerados no foreach abaixo
        $now = Time::now()->format('H:i');


        foreach ($period as $instance) {

            // recuperamos o tempo no formato 'hh:mm'
            $hour = Time::createFromInstance($instance)->format('H:i');


            // se não for o dia atual, fazemos o push normal
            if (!$isCurrentDay) {

                $timeRange[] = $hour;
            } else {

                // aqui dentro é dia atual, 
                // verificamos se a hora de início é maior que hora atual.
                // dessa forma só apresentaremos horários que forem maiores que o horário atual,
                // ou seja, não apresentamos horas passadas

                if ($hour > $now) {

                    $timeRange[] = $hour;
                }
            }
        }


        // finalmente retornamos os horários gerados
        return $timeRange;
    }
}
