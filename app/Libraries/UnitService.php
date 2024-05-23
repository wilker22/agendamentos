<?php

namespace App\Libraries;

use App\Entities\Unit;
use App\Models\UnitModel;

class UnitService extends MyBaseService
{
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
