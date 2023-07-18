<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UserScheduleService;
use CodeIgniter\Config\Factories;

class UserSchedulesController extends BaseController
{

    /** @var UserScheduleService */
    private UserScheduleService $userScheduleService;


    /** Construtor */
    public function __construct()
    {
        $this->userScheduleService = Factories::class(UserScheduleService::class);
    }

    public function index()
    {

        $data = [
            'title'        => 'Meus agendamentos',

            // debug
            'agendamentos' => $this->userScheduleService->all()
        ];


        return view('Front/Schedules/user_schedules', $data);
    }
}
