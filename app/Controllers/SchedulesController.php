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

    public function __construct()
    {
        $this->scheduleService = Factories::class(ScheduleService::class);
        $this->calendarService = Factories::class(CalendarService::class);
    }


    public function index()
    {
        $data = [
            'title' => 'Agendar',
            'units' =>  $this->scheduleService->renderUnits(),
            'months' => $this->calendarService->renderMonths()

        ];

        return view('Front/Schedules/index', $data);
    }

    /**
     * recupera os serviçs da uniade nforma no request
     * 
     * @return ResponseInterface
     * 
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
}
