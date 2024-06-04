<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class ButtonsCell
{
    public function action(array $params): string
    {
        $btnClass = 'btn btn-sm';
        $btnClass .= $params['activated'] ? 'btn-warning' : 'btn-success';

        $form = form_open($params['route'], ['class' => 'd-inline'], hidden: ['_method' => 'PUT']);
        $form .= form_button([
            'class' => $params['btn_class'] ?? $btnClass,
            'type' => 'submit',
            'content' => $params['text_action']
        ]);
        $form .= form_close();

        return $form;
    }

    public function destroy(array $params): string
    {
        $formAttributes = [
            'class' => 'd-inline',
            'onsubmit' => 'return confirm("Este registro será excluído!")'
        ];
        $form = form_open($params['route'], attributes: $formAttributes, hidden: ['_method' => 'DELETE']);
        $form .= form_button([
            'class' => $params['btn_class'] ?? 'btn btn-sm btn-danger',
            'type' => 'submit',
            'content' => 'Excluir'
        ]);
        $form .= form_close();

        return $form;
    }
}
