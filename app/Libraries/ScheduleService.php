<?php

namespace App\Libraries;

use App\Entities\Unit;
use App\Models\ServiceModel;
use App\Models\UnitModel;
use Exception;
use InvalidArgumentException;

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


    public function renderUnitServices(int $unitId): string
    {
        //VALIDADAR A EXISTENCIA DA UNIDADE ATIVA COM SERVIÇÕES
        $unit = model(UnitModel::class)->where(['active' => 1, 'services !=' => null, 'services !=' => ''])->findOrFail($unitId);

        //busca serviços da unidade
        $services = model(ServiceModel::class)->whereIn('id', $unit->services)->where('active', 1)->orderBy('name', 'ASC')->findAll();

        if (empty($services)) {
            throw new InvalidArgumentException("Os serviços associados à Unidae {$unit->name} nao estão ativos ou não existem");
        }

        $options = [];
        $options[''] = '--- Escolha ---';

        foreach ($services as $service) {
            $options[$service->id] = $service->name;
        }

        return form_dropdown(data: 'service', options: $options, selected: [], extra: ['id' => 'service->id', 'class' => 'form-select']);
    }
}
