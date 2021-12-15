@extends('layouts.app')

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

                        <table class="table table-striped table-inverse">
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
