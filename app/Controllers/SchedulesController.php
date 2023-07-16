<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ScheduleService;
use CodeIgniter\Config\Factories;

class SchedulesController extends BaseController
{

    /** @var ScheduleService */
    private ScheduleService $scheduleService;

    /** Construtor */
    public function __construct()
    {
        $this->scheduleService = Factories::class(ScheduleService::class);
    }


    public function index()
    {
        $data = [
            'title' => 'Criar agendamento',
            'units' => $this->scheduleService->renderUnits()
        ];

        return view('Front/Schedules/index', $data);
    }
}
