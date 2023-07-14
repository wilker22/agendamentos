<?php

namespace App\Controllers\Super;

use App\Controllers\BaseController;
use App\Models\UnitModel;
use CodeIgniter\View\RendererInterface;

class UnitsController extends BaseController
{
    /**
     * Renderiza a view para gerenciar as uniadades
     *
     * @return RendererInterface
     */
    public function index()
    {
        $data = [
            'title' => 'Unidades',
        ];

        $units = model(UnitModel::class)->findAll();

        $table = new \CodeIgniter\View\Table();

        $template = [
            'table_open' => '<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">',
        ];

        $table->setTemplate($template);

        $table->setHeading('Nome', 'E-mail', 'Telefone', 'Início', 'Fim', 'Criado');

        foreach ($units as $unit) {

            $table->addRow(
                [
                    $unit->name,
                    $unit->email,
                    $unit->phone,
                    $unit->starttime,
                    $unit->endtime,
                    $unit->created_at,
                ]
            );
        }

        $data['units'] = $table->generate();

        return view('Back/Units/index', $data);
    }
}
