@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="text-center mt-3 mb-5">Editar Conta a Receber Código N° <strong>{{ $received->id }} </strong>
                </h1>

                {{-- @php
                    dd($client->partner->file->toArray());
                @endphp --}}

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="dados_locacao-tab" data-toggle="tab" data-target="#dados_locacao"
                            type="button" role="tab" aria-controls="dados_locacao" aria-selected="true">Dados da
                            Locação</button>
                        <button class="nav-link" id="pagamentos-tab" data-toggle="tab" data-target="#pagamentos"
                            type="button" role="tab" aria-controls="pagamentos" aria-selected="false">Pagamentos</button>
                    </div>
                </nav>

                <form action="{{ route('clientes.update', $received->id) }}" method="post" enctype="multipart/form-data"
                    class="form">
                    @method('PUT')
                    @csrf

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="dados_locacao" role="tabpanel"
                            aria-labelledby="dados_cadastrais-tab">
                            <div class="row mt-5">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Nome</label>
                                        <input type="text" name="first_name" id="first_name" class="form-control"
                                            value="{{ $received->first_name }}" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Sobrenome</label>
                                        <input type="text" name="last_name" id="last_name" class="form-control"
                                            value="{{ $received->last_name }}" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>CPF / CNPJ</label>
                                        <input type="text" name="cpf_cnpj" id="cpf_cnpj" class="form-control"
                                            value="{{ $received->cpf_cnpj }}" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>E-mail</label>
                                        <input type="text" name="mail" id="mail" class="form-control"
                                            value="{{ $received->mail }}" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Telefone</label>
                                        <input type="text" name="phone" id="phone" class="form-control"
                                            value="{{ $received->phone }}" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Celular</label>
                                        <input type="text" name="celphone" id="celphone" class="form-control"
                                            value="{{ $received->celphone }}" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <hr>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>CEP</label>
                                        <input type="text" name="cep" id="cep" class="form-control"
                                            value="{{ $received->propertie['code_postal'] }}" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label>Endereço</label>
                                        <input type="text" name="address" id="rua" class="form-control"
                                            value="{{ $received->propertie['address'] }}" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Numero</label>
                                        <input type="text" name="address_number" id="address_number" class="form-control"
                                            value="{{ $received->propertie['number_address'] }}" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Complemento</label>
                                        <input type="text" name="address_complement" id="address_complement"
                                            class="form-control" value="{{ $received->propertie['complement'] }}"
                                            disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Bairro</label>
                                        <input type="text" name="district" id="bairro" class="form-control"
                                            value="{{ $received->propertie['district'] }}" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Cidade</label>
                                        <input type="text" name="city" id="cidade" class="form-control"
                                            value="{{ $received->propertie['city'] }}" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <input type="text" name="uf" id="uf" class="form-control"
                                            value="{{ $received->propertie['uf'] }}" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Tipo de Propriedade</label>
                                        <input type="text" name="uf" id="uf" class="form-control"
                                            value="{{ $received->propertie['type_propertie'] }}" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Objetivo do Imóvel</label>
                                        <input type="text" name="uf" id="uf" class="form-control"
                                            value="{{ $received->propertie['object_propertie'] }}" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pagamentos" role="tabpanel" aria-labelledby="endereco_client-tab">
                            <div class="row mt-5">
                                <div class="col-sm-12 text-right mt-5 mb-5">
                                    <a class="btn btn-primary btn-sm" href="{{ route('contas_receber.new_payment', $received->id) }}">Novo
                                        Pagamento</a>
                                </div>
                                <div class="col-sm-12">

                                    <table class="table table-striped table-inverse">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>Código de Pagamento</th>
                                                <th>Forma de Pagamento</th>
                                                <th>Valor Total</th>
                                                <th>Status</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td scope="row">222</td>
                                                <td>Boleto Bancário</td>
                                                <td>R$ 950,00</td>
                                                <td>A vencer</td>
                                                <td>
                                                    <a href="" type="button" class="btn btn-primary btn-sm">Acessar
                                                        Pagamento</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-5 mb-5">
                            <button class="btn btn-success btn-sm" type="submit">Editar Cliente</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-sm-12 mt-5 text-right">
                <a class="btn btn-default btn-sm"
                    href="{{ url('contas_receber') }}">{{ __('Voltar para Listagem') }}</a>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
