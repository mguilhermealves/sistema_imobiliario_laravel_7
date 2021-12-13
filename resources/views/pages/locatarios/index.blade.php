@extends('layouts.app')

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
                    <a class="btn btn-primary btn-sm" href="{{ route('locatarios.create') }}">Cadastrar Locátario</a>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <h1 class="text-center mt-5 mb-5">Lista de Locátarios</h1>

                        <table class="table table-striped table-inverse">
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
                                            <a href="http://" type="button" class="btn btn-danger btn-sm">Excluir</a>
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
