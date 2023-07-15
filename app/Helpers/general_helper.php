<?php


if (!function_exists('show_error_input')) {

    /**
     * Exibe o erro de validação para o campo informado, caso o mesmo tenha sido interceptado no form validation.
     *
     * @param string $inputField
     * @return string
     */
    function show_error_input(string $inputField): string
    {

        $inputField = strtolower($inputField);

        if (!session()->has('errorsValidation')) {

            return '';
        }

        $errorsValidation = esc(session('errorsValidation'));

        return !array_key_exists($inputField, $errorsValidation) ?
            '' : // retorno string vazia caso não tenha
            "<span class='text-danger'>{$errorsValidation[$inputField]}</span>"; // retorno um span com o erro
    }
}
