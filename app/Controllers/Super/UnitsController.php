<?php

namespace App\Controllers\Super;

use App\Controllers\BaseController;

class UnitsController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Unidades',
        ];

        return view('Back/Units/index', $data);
    }
}
