<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class SchedulesController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Criar agendamento',
        ];

        return view('Front/Schedules/index', $data);
    }
}
