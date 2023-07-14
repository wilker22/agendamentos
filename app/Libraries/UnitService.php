<?php

namespace App\Libraries;

use App\Entities\Unit;
use App\Models\UnitModel;

class UnitService extends MyBaseService
{

    /**
     * Renderiza uma tabela HTML com os resultados
     *
     * @return string
     */
    public function renderUnits(): string
    {

        $units = model(UnitModel::class)->orderBy('name', 'ASC')->findAll();

        if (empty($units)) {

            return self::TEXT_FOR_NO_DATA;
        }

        $this->htmlTable->setHeading('Ações', 'Nome', 'E-mail', 'Telefone', 'Início', 'Fim', 'Criado');

        foreach ($units as $unit) {

            $this->htmlTable->addRow(
                [
                    $this->renderBtnActions($unit),
                    $unit->name,
                    $unit->email,
                    $unit->phone,
                    $unit->starttime,
                    $unit->endtime,
                    $unit->created_at,
                ]
            );
        }

        return $this->htmlTable->generate();
    }


    /**
     * Renderiza os dropdown com as ações possíveis para cada registro
     *
     * @param Unit $unit
     * @return string
     */
    private function renderBtnActions(Unit $unit): string
    {

        $btnActions = '<div class="btn-group">';
        $btnActions .= '<button type="button" 
                            class="btn btn-outline-primary btn-sm dropdown-toggle" 
                            data-toggle="dropdown" 
                            aria-haspopup="true" 
                            aria-expanded="false">Ações
                        </button>';
        $btnActions .= '<div class="dropdown-menu">';
        $btnActions .= anchor(route_to('units.edit', $unit->id), 'Editar', ['class' => 'dropdown-item']);
        $btnActions .= '<a class="dropdown-item" href="#">Action</a>';
        $btnActions .= '<a class="dropdown-item" href="#">Action</a>';
        $btnActions .= ' </div>
                        </div>';

        return $btnActions;
    }
}
