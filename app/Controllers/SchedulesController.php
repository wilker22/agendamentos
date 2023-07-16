<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\CalendarService;
use App\Libraries\ScheduleService;
use CodeIgniter\Config\Factories;
use CodeIgniter\HTTP\ResponseInterface;

class SchedulesController extends BaseController
{

    /** @var ScheduleService */
    private ScheduleService $scheduleService;


    /** @var CalendarService */
    private CalendarService $calendarService;

    /** Construtor */
    public function __construct()
    {
        $this->scheduleService = Factories::class(ScheduleService::class);
        $this->calendarService = Factories::class(CalendarService::class);
    }


    public function index()
    {


        $data = [
            'title'  => 'Criar agendamento',
            'units'  => $this->scheduleService->renderUnits(),
            'months' => $this->calendarService->renderMonths(),
        ];

        // ISSO É UM DEBUG, OK?
        $data['calendario_debug'] = $this->calendarService->generate(month: 12);

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

            $unitId = (int) $this->request->getGet('unit_id');

            $services = $this->scheduleService->renderUnitServices(unitId: $unitId);

            return $this->response->setJSON([
                'services' => $services
            ]);
        } catch (\Throwable $th) {

            log_message('error', '[ERROR] {exception}', ['exception' => $th]);

            $this->response->setStatusCode(500);
        }
    }


    /**
     * Recupera o calendário para o mês desejado
     *
     * @return ResponseInterface
     */
    public function getCalendar()
    {

        try {

            $this->checkMethod('ajax');

            $month = (int) $this->request->getGet('month');

            return $this->response->setJSON([
                'calendar' => null
            ]);
        } catch (\Throwable $th) {

            log_message('error', '[ERROR] {exception}', ['exception' => $th]);

            $this->response->setStatusCode(500);
        }
    }
}
