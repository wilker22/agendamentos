<?php

namespace App\Libraries;

use App\Models\UnitModel;

class ScheduleService
{

    /**
     * Renderiza a lista com as opções de unidades ativas e que possuam serviços associados para serem escolhidas no agendamento.
     *
     * @return string
     */
    public function renderUnits(): string
    {

        // unidades ativas e com serviços associados
        $where = [
            'active' => 1,
            'services !=' => null,
            'services !=' => '',
        ];

        $units = model(UnitModel::class)->where($where)->orderBy('name', 'ASC')->findAll();

        if (empty($units)) {

            return '<div class="text-info mt-5">Não há Unidades disponíveis para agendamento</div>';
        }


        // valor padrão
        $radios = '';


        foreach ($units as $unit) {

            $checkbox = '<div class="form-check mb-2">';
            $checkbox .= "<input type='checkbox' {$checked} name='services[]' value='{$service->id}' class='custom-control-input' id='service-{$service->id}'>";
            $checkbox .= "<label class='custom-control-label' for='service-{$service->id}'>{$service->name}</label>";
            $checkbox .= '</div>';

            $ul .= "<li class='list-group-item'>{$checkbox}</li>";
        }




        // retornamo a lista de opções
        return $ul;
    }
}
