<?php

namespace App\Libraries;

use App\Entities\Unit;
use App\Models\ServiceModel;
use App\Models\UnitModel;

class ServiceService extends MyBaseService
{

    public function renderServices(): string
    {
        $services = model(ServiceModel::class)->orderBy('name', 'ASC')->findAll();

        if (empty($services)) {
            return self::TEXT_FOR_NO_DATA;
        } else {

            $this->htmlTable->setHeading('Ações', 'Nome', 'Status', 'Criado');

            foreach ($services as $service) {
                $this->htmlTable->addRow([
                    $this->renderBtnActions($service),
                    $service->name,
                    $service->status(),
                    $service->createdAt()
                ]);
            }

            return $this->htmlTable->generate();
        }
    }


    private function renderBtnActions(Unit $service): string
    {

        $btnActions  = '<div class="btn-group">';
        $btnActions .= '<button type="button" 
                                class="btn btn-outline-primary btn-sm dropdown-toggle" 
                                data-toggle="dropdown" 
                                aria-haspopup="true" 
                                aria-expanded="false">
                                    Ações
                            </button>';
        $btnActions .= '<div class="dropdown-menu">';
        $btnActions .= anchor(route_to('units.edit', $service->id), 'Editar', ['class' => 'dropdown-item']);

        $btnActions .= view_cell(
            library: 'ButtonsCell::action',
            params: [
                'route'         => route_to('units.action', $service->id),
                'text_action'   => $service->textToAction(),
                'activated'     => $service->isActivated(),
                'btn_class'     => 'dropdown-item py-2'
            ]
        );
        $btnActions .= view_cell(
            library: 'ButtonsCell::destroy',
            params: [
                'route'         => route_to('units.destroy', $service->id),
                'btn_class'     => 'dropdown-item py-2'
            ]
        );


        $btnActions .= '</div></div>';

        return $btnActions;
    }
}
