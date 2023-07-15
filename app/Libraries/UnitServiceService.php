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

        if (!empty($services)) {

            $anchor = '<div class="text-info mt-5">Não há serviços disponíveis</div>';
            $anchor .= anchor(route_to('servicess'), 'Ver serviços', ['class' => 'btn btn-sm btn-outline-primary']);
            return $anchor;
        }
    }
}
