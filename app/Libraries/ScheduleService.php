<?php

namespace App\Libraries;

use App\Entities\Unit;
use App\Models\ServiceModel;
use App\Models\UnitModel;

class ScheduleService
{

    public function renderUnits(): string
    {
        $where = [
            'active' => 1,
            'services !=' => null,
            'services !=' => ''
        ];

        $units = model(UnitModel::class)->where($where)->orderBy('name', 'ASC')->findAll();

        if (empty($units)) {
            return '<div class="text-info mt-5">Não há unidades disponíveis para agendamento!</div>';;
        }

        $radios = '';

        foreach ($units as  $unit) {
            $checked = in_array($unit->id, $existingUnitsIds ?? []) ? 'checked' : '';

            $radios .= '<div class="form-check mb-2">';
            $radios .= "<input type='radio' name='unit_id' data-unit='{$unit->name}' \nEndereço: {$unit->address} value='{$unit->id}' class='form-check-input' id='radio-unit-{$unit->id}'>";
            $radios .= "<label class='form-check-label' for='radio-unit-{$unit->id}'>{$unit->name}<br>{$unit->adress}</label>";
            $radios .= '</div>';
        }

        return $radios;
    }
}
