<?php

namespace App\Controllers\Super;

use App\Controllers\BaseController;
use App\Libraries\UnitServiceService;
use App\Models\UnitModel;
use CodeIgniter\Config\Factories;
use CodeIgniter\HTTP\RedirectResponse;
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
            'servicesOptions' => $this->unitServiceService->renderServicesOptions($unit->services),
        ];


        return view('Back/Units/services', $data);
    }


    /**
     * Processa a associação dos serviços com a unidade
     *
     * @param integer $unitId
     * @return RedirectResponse
     */
    public function store(int $unitId)
    {
        $this->checkMethod('put');

        $unit = $this->unitModel->findOrFail($unitId);

        $postServices = $this->request->getPost('services');

        $unit->services = $postServices ?? null;

        if (!$unit->hasChanged()) {

            return redirect()->back()->with('info', 'Não há dados para atualizar');
        }

        $success = $this->unitModel->save($unit);

        if (!$success) {

            return redirect()->back()
                ->withInput()
                ->with('danger', 'Verifique os erros e tente novamente')
                ->with('errorsValidation', $this->unitModel->errors());
        }


        return redirect()->back()->with('success', 'Sucesso!');
    }
}
