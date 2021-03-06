@extends('layouts.app')

@section('script')
    <script>
        $(function($) {

            $('form[name="form_create_propertie"]').submit(function(event) {
                event.preventDefault();

                var formData = new FormData($(this)[0]);

                $.ajax({
                    url: "{{ route('imoveis.store') }}",
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    processData: false,
                    contentType: false,
                    success: function(resp) {
                        if (resp.error == false) {
                            $('.message_box').removeClass('d-none').addClass('alert-success')
                                .html(resp.message);

                            setTimeout(function() {
                                window.location.replace(' {{ route('imoveis') }}');
                            }, 1500);
                        }
                    },
                    error: function(err) {
                        if (err.status ==
                            422) { // when status code is 422, it's a validation issue
                            console.log(err.responseJSON);
                            $('.message_box').removeClass('d-none').addClass('alert-danger')
                                .html(
                                    'Erro ao cadastrar o Imóvel, confira os campos marcados em vermelho.'
                                    );

                            // you can loop through the errors object and show it to the user
                            console.warn(err.responseJSON.errors);
                            // display errors on each form field
                            $.each(err.responseJSON.errors, function(i, error) {
                                var el = $(document).find('[id="' + i + '"]');
                                el.after($('<span style="color: red;">' + error[
                                    0] + '</span>'));
                            });
                        }
                    }
                });
            });

            $(document).ready(function() {

                $('#phone').mask("(99) 9999-9999");
                $('#celphone').mask("(99) 99999-9999");
                $('#code_postal').mask("99999-999");
                $('#cpf').mask("999.999.999-99");
                $('#cpf_partner').mask("999.999.999-99");
                $('.money').mask("#.##0,00", {
                    reverse: true
                });

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

            //AUTOCOMPLETE PROPERTIES
            var path = "{{ route('imoveis.autocomplete') }}";
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#id_client").autocomplete({
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: path,
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            cod_client: request.term
                        },
                        success: function(data) {
                            $("#rua").val(data.address);
                            $("#address_number").val(data.number_address);
                            $("#address_complement").val(data.number_address);
                            $("#cep").val(data.code_postal);
                            $("#bairro").val(data.district);
                            $("#cidade").val(data.city);
                            $("#uf").val(data.uf);
                        }
                    });
                }
            });
        });
    </script>
@endsection

@section('content')
    <div class="alert d-none message_box" role="alert">

    </div>

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

                <form name="form_create_propertie" enctype="multipart/form-data" class="form">
                    @csrf

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="endereco_imovel" role="tabpanel"
                            aria-labelledby="endereco_imovel-tab">
                            <div class="row mt-5 mb-5">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Código do Cliente</label>
                                        <input type="text" id="id_client" name="cod_client" class="form-control"
                                            placeholder="Consultar Cliente" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Tipo de Imóvel</label>
                                        <select class="custom-select" name="type_propertie" id="type_propertie">
                                            <option value="" selected>Selecione...</option>
                                            @foreach ($type_propertie as $type)
                                                <option value="{{ $type->slug }}"> {{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>CEP</label>
                                        <input type="text" name="cep" id="cep" placeholder="00000-000"
                                            class="form-control" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label>Endereço</label>
                                        <input type="text" name="address" id="rua" class="form-control" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Numero</label>
                                        <input type="text" name="address_number" id="address_number" class="form-control"
                                            disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Complemento</label>
                                        <input type="text" name="address_complement" id="address_complement"
                                            class="form-control" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Bairro</label>
                                        <input type="text" name="district" id="bairro" class="form-control" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Cidade</label>
                                        <input type="text" name="city" id="cidade" class="form-control" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <input type="text" name="uf" id="uf" class="form-control" disabled>
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
                                            <option value="" selected>Selecione o objetivo</option>
                                            @foreach ($objective_properties as $objective)
                                                <option value="{{ $objective->slug }}"> {{ $objective->name }}</option>
                                            @endforeach
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
                                                <input type="text" name="price_location" class="form-control money"
                                                    autofocus>
                                            </div>
                                        </div>

                                        <div class="col-sm-4" name="sale">
                                            <div class="form-group">
                                                <label>Valor Venda</label>
                                                <input type="text" name="price_sale" class="form-control money" autofocus>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Valor IPTU</label>
                                                <input type="text" name="price_iptu" class="form-control money" autofocus>
                                            </div>
                                        </div>

                                        <div class="col-sm-4" name="is_apartmant">
                                            <div class="form-group">
                                                <label>Valor do Condominio</label>
                                                <input type="text" name="price_condominium" class="form-control money"
                                                    autofocus>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Prazo Contrato</label>
                                                <select class="custom-select" name="deadline_contract"
                                                    id="deadline_contract">
                                                    <option value="" selected>Selecione o objetivo</option>
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
                                                    <option value="" selected>Selecione o objetivo</option>
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
                                                    <option value="" selected>Selecione</option>
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
                <a class="btn btn-default btn-sm" href="{{ url('imoveis') }}">{{ __('<< Voltar para Listagem') }}</a>
            </div>
        </div>
    </div>
@endsection
