@component('mail::message')
<h1>Teste</h1>

<p>TESTE NOVO PAGAMENTO GERADO COM SUCESSO!</p>

@component('mail::button', ['url' => 'http://www.google.com.br'])
    Ver Boleto
@endcomponent

@endcomponent
