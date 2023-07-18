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


            $btnCancel = '';

            if ($schedule->canBeCanceled()) {

                $btnCancel .= $this->renderBtnCancel($schedule->id);
            }


            $ul .= "<div class='ms-2 me-auto'><div class='fw-bold'>{$schedule->unit} {$schedule->address}</div>
                    {$schedule->service}
                    <p>{$btnCancel}</p>
                    </div>";


            $ul .= $schedule->situation();


            $ul .= '</li>';
        }


        $ul .= '</ul>';


        return $ul;
    }


    /**
     * Renderiza o botão HTML para cancelar o agendamento.
     *
     * @param integer|string $id
     * @return string
     */
    private function renderBtnCancel(int|string $id): string
    {

        return form_button([
            'class'         => 'btn btn-danger mt-4 btn-sm btnCancelSchedule',
            'data-schedule' => $id,
        ], 'Cancelar');
    }
}
