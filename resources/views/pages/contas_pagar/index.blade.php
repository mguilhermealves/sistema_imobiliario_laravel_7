@extends('layouts.app')

@section('script')
    <script>
        $(function($) {
            $(document).ready(function() {

                $('.money').mask("#.##0,00", {
                    reverse: true
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
                <div class="container text-right mt-5">
                    <a class="btn btn-primary btn-sm" href="{{ route('contas_pagar.contas.create') }}">Cadastrar
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
                                            <a href="{{ route('clientes.show', $account_pay->id) }}" type="button"
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

                        @if ($account_pays != null)
                            <a class="btn btn-primary btn-sm" href="{{ route('export_client') }}">Exportar
                                Excel</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
