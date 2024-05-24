<?php

namespace App\Libraries;

use App\Entities\Unit;
use App\Models\UnitModel;

class UnitService extends MyBaseService
{

    private static $serviceTimes = [
        '10 minutes' => '10 minutos',
        '15 minutes' => '15 minutos',
        '30 minutes' => '30 minutos',
        '1 hour' => 'Uma hora',
        '2 hour' => 'Duas horas',

    ];

    public function renderUnits(): string
    {
        $units = model(UnitModel::class)->orderBy('name', 'ASC')->findAll();

        if (empty($units)) {
            return self::TEXT_FOR_NO_DATA;
        } else {
            $this->htmlTable->setHeading('Ações', 'Nome', 'Email', 'Telefone', 'Início', 'Fim', 'Criado');
            foreach ($units as $unit) {
                $this->htmlTable->addRow([
                    $this->renderBtnActions($unit),
                    $unit->name,
                    $unit->email,
                    $unit->phone,
                    $unit->starttime,
                    $unit->endtime,
                    $unit->created_at
                ]);
            }

            return $this->htmlTable->generate();
        }
    }

    public function renderTimesInterval(?string $serviceTime = null): string
    {
        $options = [];
        $options[''] = '---Escolha---';

        foreach (self::$serviceTimes as $key => $time) {
            $options[$key] = $time;
        }

        return form_dropdown(
            data: 'servicetime',
            options: $options,
            selected: old('servicetime', $serviceTime),
            extra: ['class' => 'form-control']
        );
    }

    private function renderBtnActions(Unit $unit): string
    {

        $btnActions  = '<div class="btn-group dropup">';
        $btnActions .= '<button type="button" 
                                class="btn btn-outline-primary btn-sm dropdown-toggle" 
                                data-toggle="dropdown" 
                                aria-haspopup="true" 
                                aria-expanded="false">
                                    Ações
                            </button>';
        $btnActions .= '<div class="dropdown-menu">';
        $btnActions .= anchor(route_to('units.edit', $unit->id), 'Editar', ['class' => 'dropdown-item']);
        $btnActions .= '<a class="dropdown-item" href="#">Action</a>';
        $btnActions .= '<a class="dropdown-item" href="#">Action</a>';
        $btnActions .= '</div></div>';

        return $btnActions;
    }
}
