<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UserScheduleService;
use CodeIgniter\Config\Factories;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\View\RendererInterface;

class UserSchedulesController extends BaseController
{

    /** @var UserScheduleService */
    private UserScheduleService $userScheduleService;


    /** Construtor */
    public function __construct()
    {
        $this->userScheduleService = Factories::class(UserScheduleService::class);
    }

    /**
     * Renderiza a view para o user logado gerenciar seus agendamentos
     *
     * @return RendererInterface
     */
    public function index()
    {

        $data = [
            'title'        => 'Meus agendamentos',
        ];


        return view('Front/Schedules/user_schedules', $data);
    }


    /**
     * Recupera os agendamentos do usuário logado.
     *
     * @return ResponseInterface
     */
    public function all()
    {

        try {

            $this->checkMethod('ajax');

            $schedules = $this->userScheduleService->all();

            return $this->response->setJSON([
                'schedules' => $schedules
            ]);
        } catch (\Throwable $th) {

            log_message('error', '[ERROR] {exception}', ['exception' => $th]);

            $this->response->setStatusCode(500);
        }
    }
}
