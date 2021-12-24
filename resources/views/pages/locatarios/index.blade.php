@extends('layouts.app')

@section('script')
    <script>
        $(function($) {
            $(document).ready(function() {

                $('#table-locatarios').DataTable({
                    "order": [
                        [0, "desc"]
                    ],
                    language: {
                        pageLength: 100,
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
                });
            });
        });
    </script>
@endsection

@section('content')

    <div class="alert alert-danger d-none message_box" role="alert">

    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="container text-right mt-5">
                    <a class="btn btn-primary btn-sm" href="{{ route('locatarios.create') }}">Cadastrar Locátario</a>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <h1 class="text-center mt-5 mb-5">Lista de Locátarios</h1>

                        <table class="table table-striped table-inverse" id="table-locatarios">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>Código da Locação</th>
                                    <th>Nome do Locátario</th>
                                    <th>Código do Imóvel</th>
                                    <th>Status</th>
                                    <th>Protocolo</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tenants as $tenant)
                                    <tr>
                                        <td scope="row">{{ $tenant->id }}</td>
                                        <td>{{ $tenant->first_name . ' ' . $tenant->last_name }}</td>
                                        <td>{{ $tenant->propertie['id'] }}</td>
                                        <td>
                                            @if ($tenant->is_aproved == 'on_approval')
                                                {{ 'Em Aprovação' }}
                                            @elseif ($tenant->is_aproved == 'approved')
                                                {{ 'Aprovado' }}
                                            @else
                                                {{ 'Não Aprovado' }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($tenant->n_contract != null && $tenant->is_aproved == 'approved')
                                                {{ $tenant->n_contract }}
                                            @else
                                                {{ 'Aguardando protocolo...' }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('locatarios.show', $tenant->id) }}" type="button"
                                                class="btn btn-primary btn-sm">Editar</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <th colspan="6" style="text-align: center">Nenhuma locação criada até o momento...
                                        </th>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
