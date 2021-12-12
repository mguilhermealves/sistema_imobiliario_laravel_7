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
                                <tr>
                                    <td>1</td>
                                    <td>Marcos Guilherme</td>
                                    <td>006</td>
                                    <td>Aprovado</td>
                                    <td>20211212144000</td>
                                    <td>
                                        <a href="">BTN 1</a>
                                        <a href="">BTN 2</a>
                                    </td>
                                </tr>
                                {{-- @forelse ($clients as $client)
                                    <tr>
                                        <td scope="row">{{ $client->id }}</td>
                                        <td>{{ $client->first_name . ' ' . $client->last_name}}</td>
                                        <td>{{ $client->cpf_cnpj }}</td>
                                        <td>
                                            <a href="{{ route('clientes.show', $client->id) }}" type="button" class="btn btn-primary btn-sm">Editar</a>
                                            <a href="http://" type="button" class="btn btn-danger btn-sm">Excluir</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <th colspan="6" style="text-align: center">Nenhum cliente criado até o momento...</th>
                                    </tr>
                                @endforelse --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
