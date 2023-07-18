<?php

namespace Config;

use App\Entities\Schedule;
use App\Notifications\CanceledScheduleNotification;
use App\Notifications\NewScheduleNotification;
use CodeIgniter\Events\Events;
use CodeIgniter\Exceptions\FrameworkException;

/*
 * --------------------------------------------------------------------
 * Application Events
 * --------------------------------------------------------------------
 * Events allow you to tap into the execution of the program without
 * modifying or extending core files. This file provides a central
 * location to define your events, though they can always be added
 * at run-time, also, if needed.
 *
 * You create code that can execute by subscribing to events with
 * the 'on()' method. This accepts any form of callable, including
 * Closures, that will be executed when the event is triggered.
 *
 * Example:
 *      Events::on('create', [$myInstance, 'myMethod']);
 */

Events::on('pre_system', static function () {
    if (ENVIRONMENT !== 'testing') {
        if (ini_get('zlib.output_compression')) {
            throw FrameworkException::forEnabledZlibOutputCompression();
        }

        while (ob_get_level() > 0) {
            ob_end_flush();
        }

        ob_start(static fn ($buffer) => $buffer);
    }

    /*
     * --------------------------------------------------------------------
     * Debug Toolbar Listeners.
     * --------------------------------------------------------------------
     * If you delete, they will no longer be collected.
     */
    if (CI_DEBUG && !is_cli()) {
        Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
        Services::toolbar()->respond();
    }
});


/**
 * Envia o e-mail de notificação de agendamento criado
 */
Events::on('schedule_created', static function (string $email, Schedule $schedule) {

    (new NewScheduleNotification(email: $email, schedule: $schedule))->send();
});




/**
 * Envia o e-mail de notificação de cancelamento de agendamento
 */
Events::on('schedule_canceled', static function (string $email, Schedule $schedule) {

    (new CanceledScheduleNotification(email: $email, schedule: $schedule))->send();
});
