<?php

namespace App\Controllers\Super;

use App\Controllers\BaseController;
use App\Entities\Unit;
use App\Libraries\UnitServiceService;
use App\Models\UnitModel;
use CodeIgniter\Config\Factories;
use CodeIgniter\Config\Factory;
use CodeIgniter\HTTP\ResponseInterface;

class UnitsServicesController extends BaseController
{

    private UnitModel $unitModel;
    private UnitServiceService $unitServiceService;

    public function __construct()
    {
        $this->unitModel = model(UnitModel::class);
        $this->unitServiceService = Factories::class(UnitServiceService::class);
    }


    public function services(int $unitId)
    {
        $data = [
            'title' => "Gerenciar Serviços da Unidade",
            'unit' => $unit = $this->unitModel->findOrFail($unitId),
            'servicesOptions' => $this->unitServiceService->renderServicesOptions()
        ];

        return view('Back/Units/services', $data);
    }
}
