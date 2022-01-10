<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Contrato de Locação n° {{ $tenant->n_contract }}</title>

    <style>

    </style>
</head>

<body>
    <p style="text-align: center;font-weight: 600">Contrato de Locação n° {{ $tenant->n_contract }}</p>

    <table style="width:100%; padding: 0 3%;">
        <tr>
            <th style="background-color: 000080;color: #000080; text-align: center;">Dados do Locatário</th>
        </tr>
        <tr>
            <td>
                <strong>1. Contratante:</strong>
                <p> Locatário denominado:

                    {{ $tenant['first_name'] . ' ' . $tenant['last_name'] . ', ' }}

                    {{ ' CPF/CNPJ: ' . $tenant['cpf_cnpj'] . ', ' }}

                    {{ ' E-mail: ' . $tenant['mail'] . ', ' }}

                    {{ ' RG: ' . $tenant['rg'] . ', ' }}

                    {{ ' Telefone: ' . $tenant['phone'] . ', ' }}

                    {{ ' Celular: ' . $tenant['celphone'] . ', ' }}

                    {{ . $tenant['genre'] . '(a), ' }}

                    {{ . $tenant['marital_status'] . '(a), ' }}

                    localizado(a) no endereço:

                    {{ $tenant->address->address . ', ' }}

                    {{ $tenant->address->complement == null ? ' N°: ' . $tenant->complement->address . ', ' : ' N°: ' . $tenant->address->number_address . ', Complemento: ' . $tenant->address->complement . ', ' }}

                    {{ ' CEP: ' . $tenant->address->code_postal . ', ' }}

                    {{ ' Bairro: ' . $tenant->address->district . ', ' }}

                    {{ ' Cidade: ' . $tenant->address->city . ', ' }}

                    {{ ' UF: ' . $tenant->address->uf . ', ' }}
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <strong>3. Dados do Proprietário:</strong>
                <p>Inserir aqui...</p>
            </td>
        </tr>
        <tr>
            <td>
                <strong>2. Objeto do Contrato:</strong>
                <p>Inserir aqui...</p>
            </td>
        </tr>
        <tr>
            <td>
                <strong>4. Público:</strong>
                <p>Inserir aqui...</p>
            </td>
        </tr>
        <tr>
            <td>
                <strong>5. Período de duração do contrato:</strong>
                <p>Inserir aqui...</p>
            </td>
        </tr>
        <tr>
            <td>
                <strong>8. Forma de pagamento:</strong>
                <p></p>
            </td>
        </tr>
        <tr>
            <td>
                <strong>9. Local e data:</strong>
                <p>São Paulo,
                    @php
                        echo date('d');
                    @endphp
                    , de @php
                        echo date('m');
                    @endphp
                    , de @php
                    echo date('y');
                @endphp
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Assinatura Locatário:</strong>
                <p>________________________________________________</p>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Assinatura Proprietário:</strong>
                <p>________________________________________________</p>
            </td>
        </tr>
    </table>
</body>

</html>
