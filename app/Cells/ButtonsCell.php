<?php

namespace App\Cells;



class ButtonsCell 
{
    /**
     * Renderiza um botão com form HTML para ativar ou desativar registro
     * @param array $params[
     *      'route' => 'units/action/1',
     *      'text_action' => 'Ativar' ou 'Desativar'
     *      'activated' => true or false
     *      'btn_class' => 'btn-primary sua-classe'
      *  ]
      @return string
     */
    public function action(array $params) : string
    {
        $btnClass = 'btn btn-sm';
        $btnClass .= $params['activated'] ? 'btn-warning' : 'btn-success';

        $form = form_open($params['route'], ['class' => 'd-inline'], hidden:['_method' => 'PUT']);
        $form .= form_button([
            'class' => $params['btn_class'] ?? $btnClass,
            'type' => 'submit',
            'content' => $params['text_action']
        ]);
        $form .= form_close();

        return $form;
    }

    public function destroy(array $params) : string
    {
        $formAttributes = [
            'class' => 'd-inline',
            'onsubmit' => 'return confirm("Este registro será excluído!")'
        ] ;
        $form = form_open($params['route'], attributes: $formAttributes, hidden:['_method' => 'DELETE']);
        $form .= form_button([
            'class' => $params['btn_class'] ?? 'btn btn-sm btn-danger',
            'type' => 'submit',
            'content' => 'Remover'
        ]);
        $form .= form_close();

        return $form;
    }
}