@extends('layouts.app')

@section('script')
    <script>
        $(function($) {
            $(document).ready(function() {

                $('#table-imoveis').DataTable({
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

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="container text-right mt-5">
                    <a class="btn btn-primary btn-sm" href="{{ route('imoveis.create') }}">Cadastrar Imóvel</a>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <h1 class="text-center mt-5 mb-5">Lista de Imóveis</h1>

                        <table class="table table-striped table-inverse" id="table-imoveis">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>Código do Imóvel</th>
                                    <th>Endereco</th>
                                    <th>Bairro</th>
                                    <th>Cidade</th>
                                    <th>Estado</th>
                                    <th>Status</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($properties as $propertie)
                                    <tr>
                                        <td scope="row">{{ $propertie->id }}</td>
                                        <td>{{ $propertie->address . ', ' . $propertie->number_address }}</td>
                                        <td>{{ $propertie->district }}</td>
                                        <td>{{ $propertie->city }}</td>
                                        <td>{{ $propertie->uf }}</td>
                                        <td>{{ $propertie->active == 1 ? 'Ativo' : 'Inativo' }}</td>
                                        <td>
                                            <a href="{{ route('imoveis.show', $propertie->id) }}" type="button"
                                                class="btn btn-primary btn-sm">Editar</a>
                                            <a href="http://" type="button" class="btn btn-danger btn-sm">Excluir</a>
                                        </td>
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
                </div>
            </div>
        </div>
    </div>
@endsection
