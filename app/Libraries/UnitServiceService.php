<?php

namespace App\Libraries;

use App\Entities\Unit;
use App\Models\ServiceModel;
use App\Models\UnitModel;

class UnitServiceService extends MyBaseService
{

    public function renderServicesOptions(?array $existingServicesId = null): string
    {
        $services = model(ServiceModel::class)->orderBy('name', 'ASC')->findAll();

        if (empty($services)) {
            $anchor = '<div class="text-info mt-5">Não há serviços disponíveis!</div>';
            $anchor .= anchor(route_to('services'), 'Ver Serviços', ['class' => 'btn btn-sm btn-outline-primary']);

            return $anchor;
        }

        $ul = '<ul class="list-group">';
        foreach ($services as  $service) {
            $checked = in_array($service->id, $existingServicesIds ?? []) ? 'checked' : '';
            $checkbox = '<div class="custom-control custom-checkbox">';
            $checkbox .= "<input type='checkbox' {$checked} name='services[]' values='{$service->id}' class='custom-control-input' id='service-{$service->id}'>";
            $checkbox .= "<label class='custom-control-label' for='service-{$service->id}'>{$service->name}</label>";
            $checkbox .= '</div>';

            $ul .= "<li class='list-group-item'>{$checkbox}</li>";
        }

        $ul .= '</ul>';

        return $ul;
    }
}
