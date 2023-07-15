<?php

namespace App\Libraries;

use App\Models\ServiceModel;

class UnitServiceService extends MyBaseService
{

    /**
     * Renderiza a lista com as opções de serviços disponíveis para associação através de checkbox.
     *
     * @param array|null $existingServicesIds
     * @return string
     */
    public function renderServicesOptions(?array $existingServicesIds = null): string
    {

        $services = model(ServiceModel::class)->orderBy('name', 'ASC')->findAll();

        if (empty($services)) {

            $anchor = '<div class="text-info mt-5">Não há serviços disponíveis</div>';
            $anchor .= anchor(route_to('servicess'), 'Ver serviços', ['class' => 'btn btn-sm btn-outline-primary']);
            return $anchor;
        }

        $ul = '<ul class="list-group">';


        foreach ($services as $service) {

            $checked = in_array($service->id, $existingServicesIds ?? []) ? 'checked' : '';

            $checkbox = '<div class="custom-control custom-checkbox">';
            $checkbox .= "<input type='checkbox' {$checked} name='services[]' value='{$service->id}' class='custom-control-input' id='service-{$service->id}'>";
            $checkbox .= "<label class='custom-control-label' for='service-{$service->id}'>{$service->name}</label>";
            $checkbox .= '</div>';

            $ul .= "<li class='list-group-item'>{$checkbox}</li>";
        }

        $ul .= '</ul>';


        // retornamo a lista de opções
        return $ul;
    }
}