<?php

namespace App\Controllers\Super;

use App\Controllers\BaseController;
use App\Entities\Service;
use App\Libraries\serviceService;
use App\Models\serviceModel;
use CodeIgniter\Config\Factories;

class ServicesController extends BaseController
{

    private serviceService $serviceService;
    private serviceModel $serviceModel;

    public function __construct()
    {
        $this->serviceService = Factories::class(serviceService::class);
        $this->serviceModel = model(serviceModel::class);
    }

    public function index()
    {
        $data = [
            'title' => 'Unidades',
            'Services' => $this->serviceService->renderServices()

        ];

        $Services = model(serviceModel::class)->findAll();

        return view('Back/Services/index', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Criar Serviço',
            'Service' => new Service(),

        ];


        return view('Back/Services/new', $data);
    }

    public function create()
    {
        $this->checkMethod('post');
        $Service = new Service($this->clearRequest());

        if (!$this->serviceModel->insert($Service)) {
            return redirect()->back()
                ->withInput()
                ->with('danger', 'Verifique os erros e tente novamente!')
                ->with('errorsValidation', $this->serviceModel->errors());
        }

        return redirect()->route('Services')->with('success', 'Unidade criada com sucesso!');
    }

    public function edit(int $id)
    {
        //$this->checkMethod($request->method);

        $data = [
            'title' => 'Editar Unidade',
            'Service' => $Service = $this->serviceModel->findOrFail($id),

        ];

        return view('Back/Services/edit', $data);
    }

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
                ->with('danger', 'Verifique os erros e tente novamente!')
                ->with('errorsValidation', $this->serviceModel->errors());
        }

        return redirect()->route('Services')->with('success', 'Dados atualizados com sucesso!');
    }


    public function action(int $id)
    {
        $this->checkMethod('put');
        $service = $this->serviceModel->findOrFail($id);
        $service->setAction();
        $this->serviceModel->save($service);

        return redirect()->route('Services')->with('success', 'Ação realizada com sucesso!');
    }

    public function destroy(int $id)
    {
        $this->checkMethod('delete');
        $service = $this->serviceModel->findOrFail($id);
        $this->serviceModel->delete($service->id);
        return redirect()->route('Services')->with('success', 'Removido com sucesso!');
    }
}
