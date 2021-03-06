@extends('layouts.app')

@section('content')
    <div class="alert alert-danger d-none message_box" role="alert">

    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <h1 class="text-center mt-5 mb-5">Lista de Contas a Receber</h1>

                        <table class="table table-striped table-inverse">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>Código do Locátario</th>
                                    <th>Nome do Locátario</th>
                                    <th>N° Contrato</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tenants as $tenant)
                                    <tr>
                                        <td scope="row">{{ $tenant->id }}</td>
                                        <td>{{ $tenant->first_name . ' ' . $tenant->last_name }}</td>
                                        <td>{{ $tenant->n_contract }}</td>
                                        <td>
                                            <a href="{{ route('contas_receber.show', $tenant->id) }}" type="button"
                                                class="btn btn-primary btn-sm">Acessar Pagamentos</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <th colspan="6" style="text-align: center">Nenhum pagamento disponível até o
                                            momento...</th>
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
