<?php

namespace App\Controllers\Super;

use App\Controllers\BaseController;
use App\Libraries\UnitService;
use App\Models\UnitModel;
use CodeIgniter\Config\Factories;
use CodeIgniter\HTTP\RedirectResponse;
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


    /**
     * Processa a atualização do registro na base de dados
     *
     * @param integer $id
     * @return RedirectResponse
     */
    public function update(int $id)
    {
        $this->checkMethod('put');

        $unit = $this->unitModel->findOrFail($id);

        $unit->fill($this->clearRequest());

        if (!$unit->hasChanged()) {

            return redirect()->back()->with('info', 'Não há dados para atualizar');
        }

        $success = $this->unitModel->save($unit);

        dd($this->unitModel->errors());

        if (!$success) {

            return redirect()->back()
                ->withInput()
                ->with('danger', 'Verifique os erros e tente novamente')
                ->with('errorsValidation', $this->unitModel->errors());
        }
    }
}
