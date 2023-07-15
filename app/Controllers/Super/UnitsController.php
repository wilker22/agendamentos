<?php

namespace App\Controllers\Super;

use App\Controllers\BaseController;
use App\Libraries\UnitService;
use App\Models\UnitModel;
use CodeIgniter\Config\Factories;
use CodeIgniter\View\RendererInterface;

class UnitsController extends BaseController
{

    /** @var UnitService */
    private UnitService $unitService;

    /** @var UnitModel */
    private UnitModel $unitModel;

    /** construtor */
    public function __construct()
    {
        $this->unitService = Factories::class(UnitService::class);
        $this->unitModel = model(UnitModel::class);
    }

    /**
     * Renderiza a view para gerenciar as uniadades
     *
     * @return RendererInterface
     */
    public function index()
    {
        $data = [
            'title' => 'Unidades',
            'units' => $this->unitService->renderUnits()
        ];

        return view('Back/Units/index', $data);
    }


    /**
     * Renderiza a view para editar o registro
     *
     * @param integer $id
     * @return RendererInterface
     */
    public function edit(int $id)
    {

        $data = [
            'title'         => 'Editar unidade',
            'unit'          => $unit = $this->unitModel->findOrFail($id),
            'timesInterval' => $this->unitService->renderTimesInterval($unit->servicetime)
        ];

        return view('Back/Units/edit', $data);
    }
}
