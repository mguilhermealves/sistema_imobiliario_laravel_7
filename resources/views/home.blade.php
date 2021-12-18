@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-6 mt-5 mb-5">
                    Ultimos Cadastros de Propriedades
                    <table class="table table-striped table-inverse">
                        <thead class="thead-inverse">
                            <tr>
                                <th>id</th>
                                <th>Nome</th>
                                <th>Local</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td scope="row">99</td>
                                    <td>João</td>
                                    <td>Rua Teste, 12</td>
                                </tr>
                                <tr>
                                    <td scope="row">98</td>
                                    <td>Paulo</td>
                                    <td>Rua Teste 2, 24</td>
                                </tr>
                            </tbody>
                    </table>
                </div>

                <div class="col-sm-6 mt-5 mb-5">
                    Ultimos Pagamentos Gerados
                    <table class="table table-striped table-inverse">
                        <thead class="thead-inverse">
                            <tr>
                                <th>id</th>
                                <th>Nome</th>
                                <th>Metodo</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td scope="row">55</td>
                                    <td>Carlos</td>
                                    <td>Boleto</td>
                                </tr>
                                <tr>
                                    <td scope="row">54</td>
                                    <td>César</td>
                                    <td>Pix</td>
                                </tr>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
