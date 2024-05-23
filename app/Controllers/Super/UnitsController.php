<?php

namespace App\Controllers\Super;

use App\Controllers\BaseController;
use App\Libraries\UnitService;
use App\Models\UnitModel;
use CodeIgniter\Config\Factories;

class UnitsController extends BaseController
{

    private UnitService $unitService;
    private UnitModel $unitModel;

    public function __construct()
    {
        $this->unitService = Factories::class(UnitService::class);
        $this->unitModel = model(UnitModel::class);
    }

    public function index()
    {
        $data = [
            'title' => 'Unidades',
            'units' => $this->unitService->renderUnits()

        ];

        $units = model(UnitModel::class)->findAll();

        return view('Back/Units/index', $data);
    }

    public function edit(int $id)
    {
        //$this->checkMethod($request->method);

        $data = [
            'title' => 'Editar Unidade',
            'unit' => $this->unitModel->findOrFail($id)

        ];

        return view('Back/Units/edit', $data);
    }
}
