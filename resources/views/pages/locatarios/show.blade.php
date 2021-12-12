@extends('layouts.app')

@section('script')
    <script>
        $(function($) {

            $(document).ready(function() {

                $('#phone').mask("(99) 9999-9999");
                $('#celphone').mask("(99) 99999-9999");
                $('#code_postal').mask("99999-999");
                $('#cpf').mask("999.999.999-99");
                $('#cpf_partner').mask("999.999.999-99");

                var status = ($('#object_propertie').val());
                var type_propertie = ($('#type_propertie').val());
                var financial_propertie = ($('select[name="financial_propertie"]').val());
                var isswap = ($('#isswap').val());

                if (isswap == 'yes') {
                    $('div[name="text_exchange"]').show();
                } else {
                    $('div[name="text_exchange"]').hide();
                }

                if (type_propertie == 'apartmant') {
                    $('div[name="is_apartmant"]').show();
                } else {
                    $('div[name="is_apartmant"]').hide();
                }

                if (financial_propertie == 'yes') {
                    $('div[name="is_financer"]').show();
                } else {
                    $('div[name="is_financer"]').hide();
                }

                if (status == 'Venda') {
                    $('#configs').show();
                    $('div[name="sale"]').show();
                    $('div[name="location"]').hide();
                } else if (status == 'Locação') {
                    $('#configs').show();
                    $('div[name="sale"]').hide();
                    $('div[name="location"]').show();
                } else {
                    $('#configs').hide();
                    $('div[name="sale"]').hide();
                    $('div[name="location"]').hide();
                }

            });

            $('#isswap').change(function() {
                var isswap = ($(this).val());

                if (isswap == 'yes') {
                    $('div[name="text_exchange"]').show();
                } else {
                    $('div[name="text_exchange"]').hide();
                }
            });

            $('#type_propertie').change(function() {
                var type_propertie = ($(this).val());

                if (type_propertie == 'apartmant') {
                    $('div[name="is_apartmant"]').show();
                } else {
                    $('div[name="is_apartmant"]').hide();
                }
            });

            $('select[name="financial_propertie"]').change(function() {
                var financial_propertie = ($(this).val());

                if (financial_propertie == 'yes') {
                    $('div[name="is_financer"]').show();
                } else {
                    $('div[name="is_financer"]').hide();
                }
            });

            $('#object_propertie').change(function() {
                var status = ($(this).val());

                if (status == 'sale') {
                    $('#configs').show();
                    $('div[name="sale"]').show();
                    $('div[name="location"]').hide();
                } else if (status == 'location') {
                    $('#configs').show();
                    $('div[name="sale"]').hide();
                    $('div[name="location"]').show();
                } else {
                    $('#configs').hide();
                    $('div[name="sale"]').hide();
                    $('div[name="location"]').hide();
                }
            });

            /* CONSULTA CEP */
            $("#cep").change(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if (validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#rua").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#uf").val("...");
                        $("#ibge").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#rua").val(dados.logradouro);
                                $("#bairro").val(dados.bairro);
                                $("#cidade").val(dados.localidade);
                                $("#uf").val(dados.uf);
                                $("#ibge").val(dados.ibge);
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });
        });
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="text-center mt-3 mb-5">Editar Cliente Código N° <strong>{{ $client->id }} </strong> </h1>

                {{-- @php
                    dd($client->partner->file->toArray());
                @endphp --}}

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="dados_cadastrais-tab" data-toggle="tab"
                            data-target="#dados_cadastrais" type="button" role="tab" aria-controls="dados_cadastrais"
                            aria-selected="true">Dados Cadastrais</button>
                        <button class="nav-link" id="endereco_client-tab" data-toggle="tab"
                            data-target="#endereco_client" type="button" role="tab" aria-controls="endereco_client"
                            aria-selected="false">Endereço</button>
                        <button class="nav-link" id="dados_conjuge-tab" data-toggle="tab" data-target="#dados_conjuge"
                            type="button" role="tab" aria-controls="dados_conjuge" aria-selected="false">Dados
                            Conjuge</button>
                    </div>
                </nav>

                <form action="{{ route('clientes.update', $client->id) }}" method="post" enctype="multipart/form-data"
                    class="form">
                    @method('PUT')
                    @csrf

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="dados_cadastrais" role="tabpanel"
                            aria-labelledby="dados_cadastrais-tab">
                            <div class="row mt-5">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Nome</label>
                                        <input type="text" name="first_name" id="first_name" class="form-control"
                                            value="{{ $client->first_name }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Sobrenome</label>
                                        <input type="text" name="last_name" id="last_name" class="form-control"
                                            value="{{ $client->last_name }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>CPF / CNPJ</label>
                                        <input type="text" name="cpf_cnpj" id="cpf_cnpj" class="form-control"
                                            value="{{ $client->cpf_cnpj }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>RG</label>
                                        <input type="text" name="rg" id="rg" class="form-control"
                                            value="{{ $client->rg }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>CNH</label>
                                        <input type="text" name="cnh" id="cnh" class="form-control"
                                            value="{{ $client->cnh }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>E-mail</label>
                                        <input type="text" name="mail" id="mail" class="form-control"
                                            value="{{ $client->mail }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Sexo</label>
                                        <select class="custom-select" name="genre" id="genre">
                                            <option {{ $client->genre == 'male' ? 'selected' : '' }}>
                                                Masculino</option>
                                            <option {{ $client->genre == 'female' ? 'selected' : '' }}>
                                                Feminino</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Estado Civil</label>
                                        <select class="custom-select" name="marital_status" id="marital_status">
                                            <option {{ $client->marital_status == 'singer' ? 'selected' : '' }}>
                                                Solteiro</option>
                                            <option {{ $client->marital_status == 'married' ? 'selected' : '' }}>
                                                Casado
                                            </option>
                                            <option {{ $client->marital_status == 'divorced' ? 'selected' : '' }}>
                                                Divorciado</option>
                                            <option {{ $client->marital_status == 'widower' ? 'selected' : '' }}>
                                                Viúvo</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Telefone</label>
                                        <input type="text" name="phone" id="phone" class="form-control"
                                            value="{{ $client->phone }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Celular</label>
                                        <input type="text" name="celphone" id="celphone" class="form-control"
                                            value="{{ $client->celphone }}" autofocus>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="endereco_client" role="tabpanel"
                            aria-labelledby="endereco_client-tab">
                            <div class="row mt-5">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>CEP</label>
                                        <input type="text" name="cep" id="cep" class="form-control"
                                            value="{{ $client->code_postal }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label>Endereço</label>
                                        <input type="text" name="address" id="rua" class="form-control"
                                            value="{{ $client->address }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Numero</label>
                                        <input type="text" name="address_number" id="address_number" class="form-control"
                                            value="{{ $client->number_address }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Complemento</label>
                                        <input type="text" name="address_complement" id="address_complement"
                                            class="form-control" value="{{ $client->complement }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Bairro</label>
                                        <input type="text" name="district" id="bairro" class="form-control"
                                            value="{{ $client->district }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Cidade</label>
                                        <input type="text" name="city" id="cidade" class="form-control"
                                            value="{{ $client->city }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <input type="text" name="uf" id="uf" class="form-control"
                                            value="{{ $client->uf }}" autofocus>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="dados_conjuge" role="tabpanel" aria-labelledby="dados_conjuge-tab">
                            <div class="row mt-5">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Nome</label>
                                        <input type="text" name="first_name_partner" id="first_name_partner"
                                            class="form-control" value="{{ $client->partner->first_name_partner }}"
                                            autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Sobrenome</label>
                                        <input type="text" name="last_name_partner" id="last_name_partner"
                                            class="form-control" value="{{ $client->partner->last_name_partner }}"
                                            autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>CPF / CNPJ</label>
                                        <input type="text" name="cpf_cnpj_partner" id="cpf_cnpj_partner"
                                            class="form-control" value="{{ $client->partner->cpf_cnpj_partner }}"
                                            autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>RG</label>
                                        <input type="text" name="rg_partner" id="rg_partner" class="form-control"
                                            value="{{ $client->partner->rg_partner }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>CNH</label>
                                        <input type="text" name="cnh_partner" id="cnh_partner" class="form-control"
                                            value="{{ $client->partner->cnh_partner }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Certidão de Casamento</label>
                                        <input type="file" name="certification_married" id="certification_married"
                                            class="form-control" autofocus>
                                    </div>
                                </div>

                                @if (!empty($client->partner->file))
                                    <div class="col-sm-4">
                                        <label>Certidão de Casamento</label>
                                        <div class="form-group">
                                            <iframe class="pdf"
                                                src="{{ url("storage/{$client->partner->file->url}") }}" width="100%"
                                                height="200px"></iframe>
                                            <a href="{{ url("storage/{$client->partner->file->url}") }}"
                                                download>Download</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-12 mt-5 mb-5">
                            <button class="btn btn-success btn-sm" type="submit">Editar Cliente</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-sm-12 mt-5 text-right">
                <a class="btn btn-default btn-sm" href="{{ url('imoveis') }}">{{ __('Voltar para Listagem') }}</a>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection