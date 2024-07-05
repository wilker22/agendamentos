<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ScheduleService;
use CodeIgniter\Config\Factories;
use CodeIgniter\HTTP\ResponseInterface;

class SchedulesController extends BaseController
{
    private ScheduleService $scheduleService;

    public function __construct()
    {
        $this->scheduleService = Factories::class(ScheduleService::class);
    }


    public function index()
    {
        $data = [
            'title' => 'Agendar',
            'units' =>  $this->scheduleService->renderUnits()
        ];

        return view('Front/Schedules/index', $data);
    }
}
