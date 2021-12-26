@component('mail::message')
    <h1>Reenvio de Boleto</h1>

    Olá {{ $tenant->first_name . ' ' . $tenant->last_name }}, <br>
    segue abaixo o link do seu boleto, referente ao contrato N° {{ $tenant->n_contract }}.

    @component('mail::button', ['url' => $payment->historic_bank->link])
        Ver Boleto
    @endcomponent

@endcomponent
