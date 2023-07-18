<?php

namespace App\Libraries;

use App\Models\ScheduleModel;

class UserScheduleService
{

    /** @var ScheduleModel */
    private ScheduleModel $scheduleModel;


    /** Construtor */
    public function __construct()
    {
        $this->scheduleModel = model(ScheduleModel::class);
    }


    /**
     * Renderiza uma lista HTML com os agendamentos do usuário logado.
     *
     * @return string
     */
    public function all(): string
    {

        $schedules = $this->scheduleModel->getLoggedUserSchedules();


        if (empty($schedules)) {


            $anchor = '<div class="alert alert-info mb-4">Você ainda não tem agendamentos</div>';
            $anchor .= anchor(route_to('schedules.new'), 'Criar agendamentos', ['class' => 'btn btn-primary']);

            return $anchor;
        }


        $ul = '<ul class="list-group">';


        foreach ($schedules as $schedule) {

            $ul .= '<li class="list-group-item d-flex justify-content-between align-items-start">'; // abri a li


            $ul .= "<div class='ms-2 me-auto'><div class='fw-bold'>{$schedule->unit} {$schedule->address}</div>
                    {$schedule->service}
                    <p>Cancelar</p>
                    </div>";


            $ul .= $schedule->situation();


            $ul .= '</li>';
        }


        $ul .= '</ul>';


        return $ul;
    }
}
