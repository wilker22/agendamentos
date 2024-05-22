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
            'units' => model(UnitModel::class)->findAll()
        ];



        // dd($units);


        return view('Back/Units/index', $data);
    }
}
