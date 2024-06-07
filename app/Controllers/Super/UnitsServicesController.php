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
            'servicesOptions' => $this->unitServiceService->renderServicesOptions($unit->services)
        ];

        return view('Back/Units/services', $data);
    }

    public function store(int $unitId)
    {
        $this->checkMethod('put');

        $unit = $this->unitModel->findOrFail($unitId);
        $postServices = $this->request->getPost('services');
        $unit->services = $postServices ?? null;

        dd($unit);

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

        return redirect()->back()->with('success', 'Dados atualizados com sucesso!');
    }
}
