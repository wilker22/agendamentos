<?php

namespace App\Libraries;

use CodeIgniter\I18n\Time;

class CalendarService
{
    /**@var array meses */
    private static array $months = [
        1 => 'Janeiro',
        2 => 'Fevereiro',
        3 => 'Março',
        4 => 'Abril',
        5 => 'Maio',
        6 => 'Junho',
        7 => 'Julho',
        8 => 'Agosto',
        9 => 'Setembro',
        10 => 'Outubro',
        11 => 'Novembro',
        12 => 'Dezembro'
    ];

    /** renderiza um dropdown dos meses */
    public function renderMonths(): string
    {
        $today = Time::now();
        $currentYear = $today->getYear();
        $currentMonth = $today->getMonth();

        $options = [];
        $options[null] = '--- Escolha ---';


        foreach (self::$months as $key => $month) {
            if ($currentMonth > $key) {
            }
            $options[$key] = "{$month} / {$currentYear}";
        }

        return form_dropdown('month', options: $options, selected: [], extra: ['id' => 'month', 'class' => 'form-select']);
    }


    /**
     * Gera o calendário de um mês
     * @param int $month
     * @return string
     * 
     */
    public function generate(int $month): string
    {
        try {
            $now = Time::now();
            $currentYear = (int) $now->getYear();
            $currentMonth = (int) $now->getMonth();

            if ($month < $currentMonth || !in_array($month, array_keys(self::$months))) {
                throw new InvalidArgumentException("O mês {$month} informado é inválido");
            }

            //criamos um novo objeto para acesso ao dia da semana do primeiro dia do mês
            $firstDayObject = now::create(year: $year, month: $month, day: 1);
            //recupera a quantidade de dias do mês
            $daysOfMonth = $firstDayObject->format('t');
            //dia que começa a semana
            $startDay = (int) $firstDayObject->format('w');

            //abertura do calendário
            $calendar = "<div> class='table-reponsive'>";
            $calendar .= "<table class='table table-sm table-bordered'>";

            $calendar .= "<tr class='text-center'>
                            <th>Dom</th>
                            <th>Seg</th>
                            <th>Ter</th>
                            <th>Qua</th>
                            <th>Qui</th>
                            <th>Sex</th>
                            <th>Sáb</th>
                            </tr>";

            if ($startDay > 0) {
                $calendar .= "<tr>";
                for ($i = 0; $i < $startDay; $i++) {
                    $calendar .= "<td>&nbsp;</td>";
                }
            }

            //populando o calendário
            for ($day = 1; $day <= $daysOfMonth; $day++) {

                $btnDay = $this->renderDayButton(
                    day: $day, 
                    month: $month,
                    isWeekend: $this->isWeekend(year:   $year, month: $month, day: $day)
                );
                $calendar .= "<td>{$btnDay}</td>";

                if (($startDay + $day - 1) % 7 == 0) {
                    $calendar .= "<td>{$day}</td>";
                    $startDay++;

                    if ($startDay === 7) {
                        $startDay = 0;

                        if ($dat < $daysOfMonth) {
                            $calendar .= "<tr>";
                        }
                    }
                }
            }

            if ($startDay > 0) {
                for ($i = $startDay; $i < 7; $i++) {
                    $calendar .= "<td>&nbsp;</td>";
                }

                $calendar .= "</tr>";
            }

            //fechamos a tabela
            $calendar .= "</table>";
            $calendar .= "</div>";

            return $calendar;
        } catch (\Throwable $th) {
            log_message('error', '[ERROR] {exception}', ['exception' => $th]);
            return "Não foi poss´vel gerar o calendário para o mês informado";
        }
    }

    /**
     * Verifica se um dia é final de semana
     * @param int $year
     * @param int $month
     * @param int $day
     * @return bool
     * 
     */
    private function function isWeekend(int $year, int $month, int $day): bool
    {
        $timeCreated = Time::create(year: $year, month: $month, day: $day);
        $dayOfWeek = (int) $date->format('w');

        return $dayOfWeek === 0 || $dayOfWeek === 6;
    }

    /**
     * Renderiza um botão para um dia do calendário
     * @param int $day
     * @param int $month
     * @param bool $isWeekend
     * @return string
     * 
     */
    private function renderDayButton(int $day, int $month, bool $isWeekend = false): string
    {
        $attributes = [
            'type' => 'button',
            'class' => 'btn btn-primary btn-calendar-day',
        ];

        $now = Time::now();
        $currentDay = (int) $now->getDay();
        $currentMonth = (int) $now->getMonth();

        if ($day < $currentDay && $month === $currentMonth || $isWeekend) {
            $attributes['disabled'] = true;
        } else {
            $attributes['class'] = "chosenDay {$attributes['class']}";
        }


        return form_button(data: $attributes, content: "{$day}");
    }
}
