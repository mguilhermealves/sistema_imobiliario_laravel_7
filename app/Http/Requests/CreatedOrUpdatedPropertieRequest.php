<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatedOrUpdatedPropertieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type_propertie' => "required",
            'object_propertie' => "required",
            'deadline_contract' => "required",
            'financial_propertie' => "required",
            'isswap' => "required",
            'cod_client' => "required|exists:clients,id",
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'type_propertie.required' => 'O campo: "Tipo do Imovel" é obrigatório.',
            'object_propertie.required' => 'O campo: "Objetivo do Imovel" é obrigatório.',
            'deadline_contract.required' => 'O campo: "Prazo Contrato" é obrigatório.',
            'financial_propertie.required' => 'O campo: "Aceita Financiamento" é obrigatório.',
            'isswap.required' => 'O campo: "Aceita Troca" é obrigatório.',
            'cod_client.required' => 'O campo: "Codigo do Cliente" é obrigatório.',
        ];
    }
}
