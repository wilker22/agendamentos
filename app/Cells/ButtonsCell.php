<?php

namespace App\Cells;

class ButtonsCell
{
    /**
     * Renderiza um botão com formulário HTML para ativação ou desativação do registro.
     *
     * @param array $params [
     *                          'route' => 'units/action/1', 
     *                          'text_action' => 'Ativar' ou 'Desativar', 
     *                          'activated' => true ou false, 
     *                          'btn_class' => 'btn-primary sua-classe' 
     *                      ]
     * @return string
     */
    public function action(array $params): string
    {

        // classes padrão
        $btnClass = 'btn btn-sm ';
        $btnClass .= $params['activated'] ? 'btn-warning' : 'btn-success';


        $form = form_open($params['route'], ['class' => 'd-inline'], hidden: ['_method' => 'PUT']);

        $form .= form_button([
            'class'     => $params['btn_class'] ?? $btnClass,
            'type'      => 'submit',
            'content'   => $params['text_action'] // o que será exibido
        ]);

        $form .= form_close();

        return $form;
    }



    /**
     * Renderiza um botão com formulário HTML para exclusão do registro.
     *
     * @param array $params [
     *                          'route' => 'units/destroy/1', 
     *                          'btn_class' => 'btn-danger sua-classe' 
     *                      ]
     * @return string
     */
    public function destroy(array $params): string
    {

        $formAttributes = [
            'class'     => 'd-inline',
            'onsubmit'  => 'return confirm("Tem certeza da exclusão?");',
        ];

        $form = form_open($params['route'], attributes: $formAttributes, hidden: ['_method' => 'DELETE']);

        $form .= form_button([
            'class'     => $params['btn_class'] ?? ' btn btn-sm btn-danger',
            'type'      => 'submit',
            'content'   => 'Destruir' // o que será exibido
        ]);

        $form .= form_close();

        return $form;
    }
}
