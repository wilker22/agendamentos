<?php

namespace App\Controllers\Super;

use App\Controllers\BaseController;
use CodeIgniter\View\RendererInterface;

class UnitsServicesController extends BaseController
{
    /**
     * Renderiza a view para gerenciar os serviços da unidade
     *
     * @param integer $unitId
     * @return RendererInterface
     */
    public function services(int $unitId)
    {
        echo 'Serviços';
    }
}
