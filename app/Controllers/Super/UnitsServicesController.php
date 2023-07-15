<?php

namespace App\Controllers\Super;

use App\Controllers\BaseController;
use App\Libraries\UnitServiceService;
use App\Models\UnitModel;
use CodeIgniter\Config\Factories;
use CodeIgniter\View\RendererInterface;

class UnitsServicesController extends BaseController
{

    /** @var UnitModel */
    private UnitModel $unitModel;


    /** @var UnitServiceService */
    private UnitServiceService $unitServiceService;

    /** Construtor */
    public function __construct()
    {
        $this->unitModel = model(UnitModel::class);
        $this->unitServiceService = Factories::class(UnitServiceService::class);
    }

    /**
     * Renderiza a view para gerenciar os serviços da unidade
     *
     * @param integer $unitId
     * @return RendererInterface
     */
    public function services(int $unitId)
    {
        $data = [
            'title'           => 'Gerenciar serviços da unidade',
            'unit'            => $unit = $this->unitModel->findOrFail($unitId),
            'servicesOptions' => $this->unitServiceService->renderServicesOptions(),
        ];


        return view('Back/Units/services', $data);
    }
}
