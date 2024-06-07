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

        if (!empty($services)) {
            $anchor = '<div class="text-info mt-5">Não há serviços disponíveis!</div>';
            $anchor .= anchor(route_to('services'), 'Ver Serviços', ['class' => 'btn btn-sm btn-outline-primary']);

            return $anchor;
        }
    }
}
