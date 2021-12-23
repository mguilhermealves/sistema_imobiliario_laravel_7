@extends('layouts.app')

@section('script')
    <script>
        $(function($) {
            $(document).ready(function() {

                $('#table-ultimos-imoveis').DataTable({
                    "order": [
                        [0, "desc"]
                    ],
                    language: {
                        pageLength: 10,
                        processing: "Processando...",
                        search: "Pesquisar",
                        lengthMenu: "_MENU_ resultados por página",
                        info: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                        infoEmpty: "Mostrando 0 até 0 de 0 registros",
                        infoFiltered: "(Filtrados de _MAX_ registros)",
                        infoPostFix: "",
                        loadingRecords: "Processando...",
                        zeroRecords: "Nenhum registro encontrado",
                        emptyTable: "Nenhum registro encontrado",
                        paginate: {
                            first: "Primeiro",
                            previous: "Anterior",
                            next: "Próximo",
                            last: "Último"
                        },
                        aria: {
                            sortAscending: ": Ordenar colunas de forma ascendente",
                            sortDescending: ": Ordenar colunas de forma descendente"
                        }
                    },
                    bLengthChange : false,
                });
            });
        });
    </script>
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-12 mt-5 mb-5">
                    Últimos Cadastros de Imóveis
                    <table class="table table-striped table-inverse" id="table-ultimos-imoveis">
                        <thead class="thead-inverse">
                            <tr>
                                <th>id</th>
                                <th>Nome</th>
                                <th>Local</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse ($tenants as $tenant)
                                <tr>
                                    <td scope="row">{{ $tenant->id }}</td>
                                    <td>{{  $tenant->first_name . ' ' . $tenant->last_name }}</td>
                                    <td>{{ $tenant->address['address'] . ', N°' . $tenant->address['number_address'] . ', ' . $tenant->address['district'] . ', ' . $tenant->address['city'] . ', ' . $tenant->address['uf'] }}</td>
                                </tr>
                                @empty
                                    <tr>
                                        <th colspan="6" style="text-align: center">Nenhum imóvel criado até o momento...
                                        </th>
                                    </tr>
                                @endforelse
                            </tbody>
                    </table>
                </div>

                <div class="col-sm-12 mt-5 mb-5">
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
