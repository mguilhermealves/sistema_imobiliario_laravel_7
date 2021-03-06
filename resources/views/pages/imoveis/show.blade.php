@extends('layouts.app')

@section('script')
    <script>
        $(function($) {

            $(document).ready(function() {

                $('#phone').mask("(99) 9999-9999");
                $('#celphone').mask("(99) 99999-9999");
                $('.code_postal').mask("99999-999");
                $('#cpf').mask("999.999.999-99");
                $('#cpf_partner').mask("999.999.999-99");
                $('.money').mask("#.##0,00", {
                    reverse: true
                });

                var status = ($('#object_propertie').val());
                console.log(status);
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

            $('form[name="form_update_propertie"]').submit(function(event) {
                event.preventDefault();

                var formData = new FormData($(this)[0]);

                $.ajax({
                    url: "{{ route('imoveis.update', $propertie->id) }}",
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    processData: false,
                    contentType: false,
                    success: function(resp) {
                        if (resp.error == false) {
                            $('.message_box').removeClass('d-none').addClass(
                                'alert-success').html(resp.message);

                            setTimeout(function() {
                                window.location.replace(
                                    "{{ route('imoveis.show', $propertie->id) }}"
                                );
                            }, 1500);
                        } else {
                            $('.message_box').removeClass('d-none').addClass(
                                'alert-danger').html(resp.message);
                        }
                    }
                });
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
        });

        /* CONSULTA CEP */
        $("#cep").change(function() {

            //Nova vari??vel "cep" somente com d??gitos.
            var cep = $(this).val().replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Express??o regular para validar o CEP.
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
                            //CEP pesquisado n??o foi encontrado.
                            limpa_formul??rio_cep();
                            alert("CEP n??o encontrado.");
                        }
                    });
                } //end if.
                else {
                    //cep ?? inv??lido.
                    limpa_formul??rio_cep();
                    alert("Formato de CEP inv??lido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formul??rio.
                limpa_formul??rio_cep();
            }
        });
    </script>
@endsection

@section('content')
    <div class="alert d-none message_box" role="alert">

    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="text-center mt-3 mb-5">Editar Im??vel C??digo N?? <strong>{{ $propertie->id }} </strong> </h1>

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="endereco_imovel-tab" data-toggle="tab"
                            data-target="#endereco_imovel" type="button" role="tab" aria-controls="endereco_imovel"
                            aria-selected="true">Endere??o do Im??vel</button>
                        <button class="nav-link" id="obj_imovel-tab" data-toggle="tab" data-target="#obj_imovel"
                            type="button" role="tab" aria-controls="obj_imovel" aria-selected="false">Objetivo do
                            Im??vel</button>
                        <button class="nav-link" id="fotos_imovel-tab" data-toggle="tab" data-target="#fotos_imovel"
                            type="button" role="tab" aria-controls="fotos_imovel" aria-selected="false">Fotos</button>
                    </div>
                </nav>

                <form name="form_update_propertie" enctype="multipart/form-data" class="form">
                    @method('PUT')
                    @csrf

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="endereco_imovel" role="tabpanel"
                            aria-labelledby="endereco_imovel-tab">
                            <div class="row mt-5 mb-5">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>C??digo do Propriet??rio</label>
                                        <input type="text" class="form-control" name="cod_client"
                                            value="{{ $propertie->client_properties->id }}" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label>Dados do Propriet??rio Selecionado</label>
                                        <input type="text" class="form-control"
                                            value="{{ $propertie->client_properties->first_name . ' ' . $propertie->client_properties->last_name . ' | ' . $propertie->client_properties->cpf_cnpj }}"
                                            disabled>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <hr>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Tipo de Im??vel</label>
                                        <select class="custom-select" name="type_propertie" id="type_propertie">
                                            <option {{ $propertie->type_propertie == 'apartmant' ? 'selected' : '' }}>
                                                Apartamento</option>
                                            <option {{ $propertie->type_propertie == 'comercial' ? 'selected' : '' }}>
                                                Comercial</option>
                                            <option {{ $propertie->type_propertie == 'house' ? 'selected' : '' }}>Casa
                                                T??rrea</option>
                                            <option {{ $propertie->type_propertie == 'soft' ? 'selected' : '' }}>Sobrado
                                            </option>
                                            <option {{ $propertie->type_propertie == 'haunted' ? 'selected' : '' }}>
                                                Assobradado</option>
                                            <option {{ $propertie->type_propertie == 'ground' ? 'selected' : '' }}>
                                                Terreno
                                            </option>
                                            <option {{ $propertie->type_propertie == 'place' ? 'selected' : '' }}>Sitio
                                            </option>
                                            <option {{ $propertie->type_propertie == 'farm' ? 'selected' : '' }}>Chac??ra
                                            </option>
                                            <option {{ $propertie->type_propertie == 'other' ? 'selected' : '' }}>Outros
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>CEP</label>
                                        <input type="text" name="cep" id="cep" placeholder="00000-000"
                                            class="form-control code_postal" value="{{ $propertie->code_postal }}" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label>Endere??o</label>
                                        <input type="text" name="address" id="rua" class="form-control"
                                            value="{{ $propertie->address }}" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Numero</label>
                                        <input type="text" name="address_number" id="address_number" class="form-control"
                                            value="{{ $propertie->number_address }}" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Complemento</label>
                                        <input type="text" name="address_complement" id="address_complement"
                                            class="form-control" value="{{ $propertie->complement }}" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Bairro</label>
                                        <input type="text" name="district" id="bairro" class="form-control"
                                            value="{{ $propertie->district }}" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Cidade</label>
                                        <input type="text" name="city" id="cidade" class="form-control"
                                            value="{{ $propertie->city }}" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <input type="text" name="uf" id="uf" class="form-control"
                                            value="{{ $propertie->uf }}" disabled>
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
                                            <option {{ $propertie->object_propertie == 'sale' ? 'selected' : '' }} value="sale">Venda
                                            </option>
                                            <option {{ $propertie->object_propertie == 'location' ? 'selected' : '' }} value="location">
                                                Loca????o</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12" id="configs">
                                    <div class="row">
                                        <div class="col-sm-12 mt-5 mb-5" name="location">
                                            <h1 class="display-5 text-center">Dados de Loca????o</h1>
                                        </div>

                                        <div class="col-sm-12 mt-5 mb-5" name="sale">
                                            <h1 class="display-5 text-center">Dados de Venda</h1>
                                        </div>

                                        <div class="col-sm-4" name="location">
                                            <div class="form-group">
                                                <label>Valor Loca????o R$</label>
                                                <input type="text" name="price_location" class="form-control money"
                                                    value="{{ $propertie->price_location }}" autofocus>
                                            </div>
                                        </div>

                                        <div class="col-sm-4" name="sale">
                                            <div class="form-group">
                                                <label>Valor Venda R$</label>
                                                <input type="text" name="price_sale" class="form-control money"
                                                    value="{{ $propertie->price_sale }}" autofocus>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Valor IPTU R$</label>
                                                <input type="text" name="price_iptu" class="form-control money"
                                                    value="{{ $propertie->price_iptu }}" autofocus>
                                            </div>
                                        </div>

                                        <div class="col-sm-4" name="is_apartmant">
                                            <div class="form-group">
                                                <label>Valor do Condominio R$</label>
                                                <input type="text" name="price_condominium" class="form-control money"
                                                    value="{{ $propertie->price_condominium }}" autofocus>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Prazo Contrato</label>
                                                <select class="custom-select" name="deadline_contract"
                                                    id="deadline_contract">
                                                    <option
                                                        {{ $propertie->deadline_contract == '12 Meses' ? 'selected' : '' }}>
                                                        12
                                                        Meses</option>
                                                    <option
                                                        {{ $propertie->deadline_contract == '24 Meses' ? 'selected' : '' }}>
                                                        24
                                                        Meses</option>
                                                    <option
                                                        {{ $propertie->deadline_contract == '36 Meses' ? 'selected' : '' }}>
                                                        36
                                                        Meses</option>
                                                    <option
                                                        {{ $propertie->deadline_contract == '48 Meses' ? 'selected' : '' }}>
                                                        48
                                                        Meses</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Aceita Financiamento</label>
                                                <select class="custom-select" name="financial_propertie">
                                                    <option selected>Selecione o objetivo</option>
                                                    <option value="{{ $propertie->financial_propertie }}"
                                                        {{ $propertie->financial_propertie == 'yes' ? 'selected' : '' }}>
                                                        Sim
                                                    </option>
                                                    <option value="{{ $propertie->financial_propertie }}"
                                                        {{ $propertie->financial_propertie == 'no' ? 'selected' : '' }}>
                                                        N??o
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-4" name="is_financer">
                                            <div class="form-group">
                                                <label>Nome da Financiadora</label>
                                                <input type="text" name="financer_name" class="form-control"
                                                    value="{{ $propertie->financer_name }}" autofocus>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Aceita Troca</label>
                                                <select class="custom-select" name="isswap" id="isswap">
                                                    <option value="{{ $propertie->isswap }}"
                                                        {{ $propertie->isswap == 'yes' ? 'selected' : '' }}>Sim
                                                    </option>
                                                    <option value="{{ $propertie->isswap }}"
                                                        {{ $propertie->isswap == 'no' ? 'selected' : '' }}>N??o
                                                    </option>
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
                                    <div class="row text-center text-lg-start">
                                        @forelse ($propertie->images as $k => $image)
                                            <div class="col-lg-3 col-md-4 col-6">
                                                <img class="img-fluid img-thumbnail"
                                                    src="{{ url("storage/{$image->url}") }}" alt=""
                                                    style="width: 30vw; height: 10vw; object-fit: contain;">
                                            </div>
                                        @empty
                                            <p class="text-center">Nenhuma imagem cadastrada</p>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-5 mb-5">
                                    <input type="file" name="images[]" id="" multiple>
                                </div>
                            </div>

                            <div class="col-sm-12 mt-5 mb-5">
                                <button class="btn btn-success btn-sm" type="submit">Editar Im??vel</button>
                            </div>
                        </div>
                </form>
            </div>

            <div class="col-sm-12 mt-5 text-right">
                <a class="btn btn-default btn-sm" href="{{ url('imoveis') }}">{{ __('<< Voltar para Listagem') }}</a>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
