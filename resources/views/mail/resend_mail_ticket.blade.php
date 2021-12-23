@component('mail::message')
<h1>Teste</h1>

<p>Reenvio de Boleto</p>

@component('mail::button', ['url' => 'http://www.google.com.br'])
    Ver Boleto
@endcomponent

@endcomponent
