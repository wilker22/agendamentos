<?php

namespace App\Controllers\Super;

use App\Controllers\BaseController;
use App\Entities\Service;
use App\Libraries\ServiceService;
use App\Models\ServiceModel;
use CodeIgniter\Config\Factories;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\View\RendererInterface;

class ServicesController extends BaseController
{

    /** @var ServiceService */
    private ServiceService $serviceService;

    /** @var ServiceModel */
    private ServiceModel $serviceModel;

    /** construtor */
    public function __construct()
    {
        $this->serviceService = Factories::class(ServiceService::class);
        $this->serviceModel = model(ServiceModel::class);
    }

    /**
     * Renderiza a view para gerenciar os serviços
     *
     * @return RendererInterface
     */
    public function index()
    {
        $data = [
            'title'    => 'Serviços',
            'services' => $this->serviceService->renderServices()
        ];

        return view('Back/Services/index', $data);
    }


    /**
     * Renderiza a view para criar serviços
     *
     * @return RendererInterface
     */
    public function new()
    {
        $data = [
            'title'   => 'Criar serviço',
            'service' => new Service(),
        ];

        return view('Back/Services/new', $data);
    }


    /**
     * Processa a criação do registro na base de dados
     *
     * @return RedirectResponse
     */
    public function create()
    {
        $this->checkMethod('post');

        $service = new Service($this->clearRequest());

        if (!$this->serviceModel->insert($service)) {

            return redirect()->back()
                ->withInput()
                ->with('danger', 'Verifique os erros e tente novamente')
                ->with('errorsValidation', $this->serviceModel->errors());
        }

        return redirect()->route('services')->with('success', 'Sucesso!');
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
            'title'    => 'Editar serviço',
            'service'  => $this->serviceModel->findOrFail($id),
        ];

        return view('Back/Services/edit', $data);
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

        $service = $this->serviceModel->findOrFail($id);

        $service->fill($this->clearRequest());

        if (!$service->hasChanged()) {

            return redirect()->back()->with('info', 'Não há dados para atualizar');
        }

        $success = $this->serviceModel->save($service);

        if (!$success) {

            return redirect()->back()
                ->withInput()
                ->with('danger', 'Verifique os erros e tente novamente')
                ->with('errorsValidation', $this->serviceModel->errors());
        }


        return redirect()->route('services')->with('success', 'Sucesso!');
    }


    /**
     * Processa a ativação ou desativação do registro na base de dados
     *
     * @param integer $id
     * @return RedirectResponse
     */
    public function action(int $id)
    {
        $this->checkMethod('put');

        $service = $this->serviceModel->findOrFail($id);
        $service->setAction();

        $this->serviceModel->save($service);

        return redirect()->route('services')->with('success', 'Sucesso!');
    }


    /**
     * Processa a exclusão do registro na base de dados
     *
     * @param integer $id
     * @return RedirectResponse
     */
    public function destroy(int $id)
    {
        $this->checkMethod('delete');

        $service = $this->serviceModel->findOrFail($id);

        $this->serviceModel->delete($service->id);

        return redirect()->route('services')->with('success', 'Sucesso!');
    }
}
