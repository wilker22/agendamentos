<?php

namespace App\Controllers\Super;

use App\Controllers\BaseController;
use App\Models\UnitModel;

class UnitsController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Unidades',

        ];

        $units = model(UnitModel::class)->findAll();

        $table = new \CodeIgniter\View\Table();
        $table->setHeading('Nome', 'Email', 'Telefone', 'Início', 'Fim', 'Criado');

        foreach ($units as $unit) {
            $table->addRow([$unit->name, $unit->email, $unit->phone, $unit->starttime, $unit->endtime, $unit->created_at]);
        }

        $data['units'] = $table->generate();;

        return view('Back/Units/index', $data);
    }
}
