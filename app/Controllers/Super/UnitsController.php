<?php

namespace App\Controllers\Super;

use App\Controllers\BaseController;
use App\Entities\Unit;
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

    public function new()
    {
        $data = [
            'title' => 'Criar Unidade',
            'unit' => new Unit(),
            'timesInterval' => $this->unitService->renderTimesInterval()

        ];


        return view('Back/Units/new', $data);
    }

    public function create()
    {
        $this->checkMethod('post');
        $unit = new Unit($this->clearRequest());

        if (!$this->unitModel->insert($unit)) {
            return redirect()->back()
                ->withInput()
                ->with('danger', 'Verifique os erros e tente novamente!')
                ->with('errorsValidation', $this->unitModel->errors());
        }

        return redirect()->route('units')->with('success', 'Unidade criada com sucesso!');
    }

    public function edit(int $id)
    {
        //$this->checkMethod($request->method);

        $data = [
            'title' => 'Editar Unidade',
            'unit' => $unit = $this->unitModel->findOrFail($id),
            'timesInterval' => $this->unitService->renderTimesInterval($unit->servicetime)

        ];

        return view('Back/Units/edit', $data);
    }

    public function update(int $id)
    {
        $this->checkMethod('put');
        $unit = $this->unitModel->findOrFail($id);
        $unit->fill($this->clearRequest());

        if (!$unit->hasChanged()) {
            return redirect()->back()->with('info', 'Não há dados para atualizar');
        }

        $success = $this->unitModel->save($unit);

        if (!$success) {
            return redirect()->back()
                ->withInput()
                ->with('danger', 'Verifique os erros e tente novamente!')
                ->with('errorsValidation', $this->unitModel->errors());
        }

        return redirect()->route('units')->with('success', 'Dados atualizados com sucesso!');
    }
}
