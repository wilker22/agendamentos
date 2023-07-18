<?php

namespace App\Libraries;

use App\Models\ScheduleModel;

class UserScheduleService
{

    /**
     * Renderiza uma lista HTML com os agendamentos do usuário logado.
     *
     * @return string
     */
    public function all(): string
    {

        $model = model(ScheduleModel::class)->getLoggedUserSchedules();



        return "";
    }
}
