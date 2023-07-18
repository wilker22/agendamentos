<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class UserSchedulesController extends BaseController
{
    public function index()
    {

        $data = [
            'title' => 'Meus agendamentos'
        ];


        return view('Front/Schedules/user_schedules', $data);
    }
}
