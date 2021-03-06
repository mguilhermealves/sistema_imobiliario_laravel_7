@extends('layouts.app')

@section('script')
    <script>
        $(function($) {
            $(document).ready(function() {

                $('#table-clientes').DataTable({
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
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            @foreach ($errors->all() as $error)
                {{ $error }} <br />
            @endforeach
        </div>
    @endif
    @if (session('message'))
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="container text-right mt-5">
                    <a class="btn btn-primary btn-sm" href="{{ route('clientes.create') }}">Cadastrar Cliente</a>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <h1 class="text-center mt-5 mb-5">Lista de Clientes</h1>

                        <table class="table table-striped table-inverse" id="table-clientes">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>Código</th>
                                    <th>Nome Completo</th>
                                    <th>CPF/CNPJ</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($clients as $client)
                                    <tr>
                                        <td scope="row">{{ $client->id }}</td>
                                        <td>{{ $client->first_name . ' ' . $client->last_name}}</td>
                                        <td>{{ $client->cpf_cnpj }}</td>
                                        <td>
                                            <a href="{{ route('clientes.show', $client->id) }}" type="button" class="btn btn-primary btn-sm">Editar/Visualizar</a>
                                            {{-- <a href="http://" type="button" class="btn btn-danger btn-sm">Excluir</a> --}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <th colspan="6" style="text-align: center">Nenhum cliente criado até o momento...</th>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        @if ($clients != null)
                            <a class="btn btn-primary btn-sm" href="{{ route('export_client') }}">Exportar Excel</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
