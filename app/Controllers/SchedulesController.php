<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\ScheduleService;
use CodeIgniter\Config\Factories;
use CodeIgniter\HTTP\ResponseInterface;

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


    /**
     * Recupera os serviços da unidade informada no request
     *
     * @return ResponseInterface
     */
    public function unitServices()
    {

        try {


            $this->checkMethod('ajax');

            return $this->response->setJSON([
                'services' => null
            ]);
        } catch (\Throwable $th) {

            log_message('error', '[ERROR] {exception}', ['exception' => $th]);

            $this->response->setStatusCode(500);
        }
    }
}
