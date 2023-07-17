<?php

namespace App\Notifications;

use App\Entities\Schedule;
use CodeIgniter\Email\Email;
use Config\Services;

class NewScheduleNotification
{

    /** @var Email */
    protected Email $service;


    /** @var string */
    protected string $email;


    /** @var Schedule */
    protected Schedule $schedule;


    /** Construtor */
    public function __construct(string $email, Schedule $schedule)
    {

        $this->service = Services::email();

        $this->email = $email;

        $this->schedule = $schedule;
    }


    /**
     * Envia o e-mail de notificação de agendamento criado
     *
     * @return boolean
     */
    public function send(): bool
    {

        // destinatário
        $this->service->setTo($this->email);
        $this->service->setSubject('Seu agendamento foi criado');

        $data = [
            'chosen_date' => $this->schedule->chosen_date,
            'unit'        => $this->schedule->unit,
            'service'     => $this->schedule->service,
            'address'     => $this->schedule->address,
        ];

        $this->service->setMessage(view('Front/Email/schedule_created', $data));
        $this->service->setMailType('html');

        if (!$this->service->send()) {

            log_message('error', $this->service->printDebugger());

            return false;
        }

        return true;
    }
}
