<?php

namespace App\Validation;

class Schedule
{
    public function rules(): array
    {
        return [

            'unit_id' => [
                'rules'     => 'is_natural_no_zero|is_not_unique[units.id]',
                'errors'    => [
                    'is_natural_no_zero' => 'Unidade Inválida',
                    'is_not_unique'      => 'Unidade Inválida',
                ],
            ],

            'service_id' => [
                'rules'     => 'is_natural_no_zero|is_not_unique[services.id]',
                'errors'    => [
                    'is_natural_no_zero' => 'Dado errado',
                    'is_not_unique'      => 'Serviço Inválido',
                ],
            ],

            'month' => [
                'rules'     => 'required|max_length[2]',
                'errors'    => [
                    'required'   => 'Informe o mês',
                    'max_length' => 'Mês com formato Inválido',
                ],
            ],

            'day' => [
                'rules'     => 'required|max_length[2]',
                'errors'    => [
                    'required'   => 'Informe o dia',
                    'max_length' => 'Dia com formato Inválido',
                ],
            ],

            'hour' => [
                'rules'     => 'required|exact_length[5]', // hh:mm
                'errors'    => [
                    'required'     => 'Informe a hora',
                    'exact_length' => 'Hora com formato Inválido, precisa ser hh:mm',
                ],
            ],
        ];
    }
}
