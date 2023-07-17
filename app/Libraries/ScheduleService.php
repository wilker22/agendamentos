<?php

namespace App\Libraries;

use App\Models\ScheduleModel;
use App\Models\ServiceModel;
use App\Models\UnitModel;
use Exception;
use InvalidArgumentException;

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

            $radios .= '<div class="form-check mb-2">';
            $radios .= "<input type='radio' name='unit_id' data-unit='{$unit->name} \nEndereço: {$unit->address}' value='{$unit->id}' class='form-check-input' id='radio-unit-{$unit->id}'>";
            $radios .= "<label class='form-check-label' for='radio-unit-{$unit->id}'>{$unit->name}<br> Endereço: {$unit->address}</label>";
            $radios .= '</div>';
        }

        // retornamos
        return $radios;
    }


    /**
     * Recupero os serviços associados à unidade informada como um dropdown HTML
     *
     * @param integer $unitId
     * @return string
     */
    public function renderUnitServices(int $unitId): string
    {

        // validamos a existência da unidade, ativa, com serviços
        $unit = model(UnitModel::class)->where(['active' => 1, 'services !=' => null, 'services !=' => ''])->findOrFail($unitId);

        // buscamos os serviços dessa unidade
        $services = model(ServiceModel::class)->whereIn('id', $unit->services)->where('active', 1)->orderBy('name', 'ASC')->findAll();

        if (empty($services)) {

            throw new InvalidArgumentException("Os serviços associados à Unidade {$unit->name} não estão ativos ou não existem");
        }

        $options = [];
        $options[null] = '--- Escolha ---';


        foreach ($services as $service) {

            $options[$service->id] = $service->name;
        }

        return form_dropdown(data: 'service', options: $options, selected: [], extra: ['id' => 'service_id', 'class' => 'form-select']);
    }

    /**
     * Tenta criar o agendamento do user logado
     *
     * @param array $request
     * @throws Exception
     * @return boolean|string
     */
    public function createSchedule(array $request): bool|string
    {
        try {

            $model = model(ScheduleModel::class);
        } catch (\Throwable $th) {

            log_message('error', '[ERROR] {exception}', ['exception' => $th]);

            return "Internal Server Error";
        }
    }
}
