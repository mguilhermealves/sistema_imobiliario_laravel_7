@extends('layouts.app')

@section('script')
    <script>
        $(function($) {
            $(document).ready(function() {

                $('.money').mask("#.##0,00", {
                    reverse: true
                });

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

                $('#table-contas').DataTable({
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
                <h1 class="text-center mt-3 mb-5">Contas a Pagar</h1>

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="categorias-tab" data-toggle="tab" data-target="#categorias"
                            type="button" role="tab" aria-controls="categorias" aria-selected="true">Categorias</button>
                        <button class="nav-link" id="contas_pagar-tab" data-toggle="tab"
                            data-target="#contas_pagar" type="button" role="tab" aria-controls="contas_pagar"
                            aria-selected="false">Contas a Pagar</button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="categorias" role="tabpanel" aria-labelledby="categorias-tab">

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

                    <div class="tab-pane fade" id="contas_pagar" role="tabpanel" aria-labelledby="contas_pagar-tab">
                        <div class="col-sm-12">
                            <div class="container text-right mt-5">
                                <a class="btn btn-primary btn-sm"
                                    href="{{ route('contas_pagar.contas.create') }}">Cadastrar
                                    Contas</a>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <h1 class="text-center mt-5 mb-5">Lista de Contas à Pagar</h1>

                                    <table class="table table-striped table-inverse" id="table-categorias">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>Código</th>
                                                <th>Empresa Beneficiária</th>
                                                <th>Tipo de Pagamento</th>
                                                <th>Valor (R$)</th>
                                                <th>Categoria</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($account_pays as $account_pay)
                                                <tr>
                                                    <td scope="row">{{ $account_pay->id }}</td>
                                                    <td>{{ $account_pay->company_beneficiary }}</td>
                                                    <td>{{ $account_pay->method_payment->name }}</td>
                                                    <td class="money">{{ $account_pay->amount }}</td>
                                                    <td>{{ $account_pay->category->type_category }}</td>
                                                    <td>
                                                        <a href="{{ route('clientes.show', $account_pay->id) }}"
                                                            type="button"
                                                            class="btn btn-primary btn-sm">Editar/Visualizar</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <th colspan="6" style="text-align: center">Nenhum pagamento criado até
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
        </div>
    </div>
@endsection
