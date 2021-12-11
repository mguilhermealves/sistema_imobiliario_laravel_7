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
                <h1 class="text-center mt-3 mb-5">Cadastro de Imóveis</h1>

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="endereco_imovel-tab" data-toggle="tab"
                            data-target="#endereco_imovel" type="button" role="tab" aria-controls="endereco_imovel"
                            aria-selected="true">Endereço do Imóvel</button>
                        <button class="nav-link" id="obj_imovel-tab" data-toggle="tab" data-target="#obj_imovel"
                            type="button" role="tab" aria-controls="obj_imovel" aria-selected="false">Objetivo do
                            Imóvel</button>
                        <button class="nav-link" id="fotos_imovel-tab" data-toggle="tab" data-target="#fotos_imovel"
                            type="button" role="tab" aria-controls="fotos_imovel" aria-selected="false">Fotos</button>
                    </div>
                </nav>

                <form action="{{ route('imoveis.store') }}" method="post" enctype="multipart/form-data"
                    class="form">
                    @csrf

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="endereco_imovel" role="tabpanel"
                            aria-labelledby="endereco_imovel-tab">
                            <div class="row mt-5 mb-5">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Código do Cliente</label>
                                        <input type="text" name="cod_client" class="form-control"
                                            placeholder="Consultar Cliente" autofocus>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-5">
                                    <div class="form-group">
                                        <label>Tipo de Imóvel</label>
                                        <select class="custom-select" name="type_propertie" id="type_propertie">
                                            <option selected>Selecione o tipo</option>
                                            <option value="apartmant">Apartamento</option>
                                            <option value="comercial">Comercial</option>
                                            <option value="house">Casa Térrea</option>
                                            <option value="soft">Sobrado</option>
                                            <option value="haunted">Assobradado</option>
                                            <option value="ground">Terreno</option>
                                            <option value="place">Sitio</option>
                                            <option value="farm">Chacára</option>
                                            <option value="other">Outros</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>CEP</label>
                                        <input type="text" name="cep" id="cep" placeholder="00000-000"
                                            class="form-control" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label>Endereço</label>
                                        <input type="text" name="address" id="rua" class="form-control" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Numero</label>
                                        <input type="text" name="address_number" id="address_number" class="form-control"
                                            autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Complemento</label>
                                        <input type="text" name="address_complement" id="address_complement"
                                            class="form-control" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Bairro</label>
                                        <input type="text" name="district" id="bairro" class="form-control" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Cidade</label>
                                        <input type="text" name="city" id="cidade" class="form-control" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <input type="text" name="uf" id="uf" class="form-control" autofocus>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="obj_imovel" role="tabpanel" aria-labelledby="obj_imovel-tab">
                            <div class="row">
                                <div class="col-sm-12 mt-5">
                                    <div class="form-group">
                                        <label>Objetivo do Imovel</label>
                                        <select class="custom-select" name="object_propertie" id="object_propertie">
                                            <option selected>Selecione o objetivo</option>
                                            <option value="sale">Venda</option>
                                            <option value="location">Locação</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12" id="configs">
                                    <div class="row">
                                        <div class="col-sm-12 mt-5 mb-5" name="location">
                                            <h1 class="display-5 text-center">Dados de Locação</h1>
                                        </div>

                                        <div class="col-sm-12 mt-5 mb-5" name="sale">
                                            <h1 class="display-5 text-center">Dados de Venda</h1>
                                        </div>

                                        <div class="col-sm-4" name="location">
                                            <div class="form-group">
                                                <label>Valor Locação</label>
                                                <input type="text" name="price_location" class="form-control" autofocus>
                                            </div>
                                        </div>

                                        <div class="col-sm-4" name="sale">
                                            <div class="form-group">
                                                <label>Valor Venda</label>
                                                <input type="text" name="price_sale" class="form-control" autofocus>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Valor IPTU</label>
                                                <input type="text" name="price_iptu" class="form-control" autofocus>
                                            </div>
                                        </div>

                                        <div class="col-sm-4" name="is_apartmant">
                                            <div class="form-group">
                                                <label>Valor do Condominio</label>
                                                <input type="text" name="price_condominium" class="form-control"
                                                    autofocus>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Prazo Contrato</label>
                                                <select class="custom-select" name="deadline_contract"
                                                    id="deadline_contract">
                                                    <option selected>Selecione o objetivo</option>
                                                    <option value="12">12 Meses</option>
                                                    <option value="24">24 Meses</option>
                                                    <option value="36">36 Meses</option>
                                                    <option value="48">48 Meses</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Aceita Financiamento</label>
                                                <select class="custom-select" name="financial_propertie">
                                                    <option selected>Selecione o objetivo</option>
                                                    <option value="yes">Sim</option>
                                                    <option value="no">Não</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-4" name="is_financer">
                                            <div class="form-group">
                                                <label>Nome da Financiadora</label>
                                                <input type="text" name="financer_name" class="form-control" autofocus>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Aceita Troca</label>
                                                <select class="custom-select" name="isswap" id="isswap">
                                                    <option selected>Selecione</option>
                                                    <option value="yes">Sim</option>
                                                    <option value="no">Não</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-12" name="text_exchange">
                                            <textarea name="comments" id="comments" rows="5" cols="150"
                                                style="overflow: auto; resize: none;"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="fotos_imovel" role="tabpanel" aria-labelledby="fotos_imovel-tab">
                            <div class="row">
                                <div class="col-sm-12 mt-5 mb-5">
                                    <input type="file" name="images[]" id="" multiple>
                                </div>
                            </div>

                            <div class="col-sm-12 mt-5 mb-5">
                                <button class="btn btn-success btn-sm" type="submit">Cadastrar Imóvel</button>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>
<script>
    $(function() {

        // $('input[name="phone"]').inputmask("(99) 9999-9999");
        // $('input[name="celphone"]').inputmask("(99) 99999-9999");
        // $('input[name="code_postal"]').inputmask("99999-999");
        // $('input[name="cpf"]').inputmask("999.999.999-99");
        // $('input[name="cpf_partner"]').inputmask("999.999.999-99");


        $(document).ready(function() {

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
