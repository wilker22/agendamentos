<?php

namespace App\Libraries;

use CodeIgniter\I18n\Time;

class CalendarService
{

    /** @var array meses */
    private static array $months = [
        1  => 'Janeiro',
        2  => 'Fevereiro',
        3  => 'Março',
        4  => 'Abril',
        5  => 'Maio',
        6  => 'Junho',
        7  => 'Julho',
        8  => 'Agosto',
        9  => 'Setembro',
        10 => 'Outubro',
        11 => 'Novembro',
        12 => 'Dezembro'
    ];


    /**
     * Renderiza um dropdown dos meses para serem escolhidos no agendamento
     *
     * @return string
     */
    public function renderMonths(): string
    {
        $today          = Time::now();
        $currentYear    = $today->getYear();
        $currentMonth   = $today->getMonth();

        $options = [];
        $options[null] = '--- Escolha ---';

        foreach (self::$months as $key => $month) {

            // mês atual é maior que '$key' 
            if ($currentMonth > $key) {

                // então continuamos para o próximo item do array,
                // pois não queremos exibir meses passados
                continue;
            }

            $options[$key] = "{$month} / {$currentYear}";
        }

        return form_dropdown(data: 'month', options: $options, selected: [], extra: ['id' => 'month', 'class' => 'form-select']);
    }
}
