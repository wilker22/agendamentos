<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\CalendarService;
use App\Libraries\ScheduleService;
use App\Libraries\UnitAvaiableHoursService;
use App\Validation\Schedule;
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
                'calendar' => $this->calendarService->generate(month: $month)
            ]);
        } catch (\Throwable $th) {

            log_message('error', '[ERROR] {exception}', ['exception' => $th]);

            $this->response->setStatusCode(500);
        }
    }


    /**
     * Recupera os horários disponíveis
     *
     * @return ResponseInterface
     */
    public function getHours()
    {

        try {

            $this->checkMethod('ajax');

            return $this->response->setJSON([
                'hours' => Factories::class(UnitAvaiableHoursService::class)->renderHours($this->request->getGet())
            ]);
        } catch (\Throwable $th) {

            log_message('error', '[ERROR] {exception}', ['exception' => $th]);

            $this->response->setStatusCode(500);
        }
    }


    /**
     * Tenta criar o agendamento
     *
     * @return ResponseInterface
     */
    public function createSchedule()
    {

        try {

            $this->checkMethod('ajax');

            $request = (array) $this->request->getJSON();

            $rules = Factories::class(Schedule::class)->rules();

            if (!$this->validateData($request, $rules)) {

                return $this->response->setStatusCode(400)->setJSON([
                    'success' => false,
                    'token'   => csrf_hash(),
                    'errors'  => $this->validator->getErrors()
                ]);
            }


            session()->setFlashdata('success', 'Agendamento criado com sucesso!');

            return $this->response->setJSON([
                'success' => true
            ]);
        } catch (\Throwable $th) {

            log_message('error', '[ERROR] {exception}', ['exception' => $th]);

            $this->response->setStatusCode(500);
        }
    }
}
