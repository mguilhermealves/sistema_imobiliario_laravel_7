@extends('layouts.app')

@section('script')
    <script>
        $(function($) {
            $(document).ready(function() {

                $('#table-categorias').DataTable({
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
                <div class="col-sm-12">
                    <div class="container text-right mt-5">
                        <a class="btn btn-primary btn-sm"
                            href="{{ route('contas_pagar.categoria.create') }}">Cadastrar
                            Categorias</a>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <h1 class="text-center mt-5 mb-5">Lista de Categorias</h1>

                            <table class="table table-striped table-inverse" id="table-categorias">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>Código</th>
                                        <th>Categoria</th>
                                        <th>Tipo</th>
                                        <th>Centro de Custo</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($categories as $category)
                                        <tr>
                                            <td scope="row">{{ $category->id }}</td>
                                            <td>{{ $category->name_category }}</td>
                                            <td>{{ $category->type_category }}</td>
                                            <td>{{ $category->cost_center_category }}</td>
                                            <td>
                                                <a href="{{ route('clientes.show', $category->id) }}"
                                                    type="button"
                                                    class="btn btn-primary btn-sm">Editar/Visualizar</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <th colspan="6" style="text-align: center">Nenhuma categoria criada até
                                                o momento...
                                            </th>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            @if ($categories != null)
                                <a class="btn btn-primary btn-sm" href="{{ route('export_client') }}">Exportar
                                    Excel</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
