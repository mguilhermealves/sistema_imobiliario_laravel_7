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
                $('.money').mask("#.##0,00", {
                    reverse: true
                });

                var status = ($('#marital_status').val());

                if (status == 'married') {
                    $("#dados_conjuge-tab").show();
                } else if (status != 'married') {
                    $("#dados_conjuge-tab").hide();
                }

                var is_pet = ($('#is_pet').val());

                if (is_pet == 'yes') {
                    $("#type_pet").show();
                } else if (is_pet != 'yes') {
                    $("#type_pet").hide();
                }

                var work = ($('#type_work').val());

                if (work == 'clt') {
                    $('#clt').show();
                    $('#pj').hide();
                } else if (work == 'pj') {
                    $('#pj').show();
                    $('#clt').hide();
                } else {
                    $('#pj').hide();
                    $('#clt').hide();
                }

                var guarantor = ($('#type_guarantor').val());

                if (guarantor == 'guarantor') {
                    $('#guarantor').show();
                    $('#type_work_guarantor_div').show();
                    $('#surety_bond').hide();
                } else if (guarantor == 'surety_bond') {
                    $('#surety_bond').show();
                    $('#type_work_guarantor_div').hide();
                    $('#guarantor').hide();
                } else {
                    $('#surety_bond').hide();
                    $('#guarantor').hide();
                    $('#type_work_guarantor_div').hide();
                }

                var type_work_guarantor = ($('#type_work_guarantor').val());

                if (type_work_guarantor == 'clt') {
                    $('#clt_guarantor').show();
                    $('#pj_guarantor').hide();
                } else if (type_work_guarantor == 'pj') {
                    $('#pj_guarantor').show();
                    $('#clt_guarantor').hide();
                } else {
                    $('#pj_guarantor').hide();
                    $('#clt_guarantor').hide();
                }

                var is_aproved = ($('#is_aproved').val());

                if (is_aproved == 'on_approval') {
                    $('#number_contract_aproved').hide();
                    $('#text_not_aproved').hide();
                } else if (is_aproved == 'approved') {
                    $('#number_contract_aproved').show();
                    $('#n_contract').attr('disabled', 'disabled');
                    $('#is_aproved').attr('disabled', 'disabled');
                    $('#text_not_aproved').hide();
                } else if (is_aproved == 'not_approved') {
                    $('#text_not_aproved').show();
                    $('#number_contract_aproved').hide();
                } else {
                    $('#text_not_aproved').hide();
                    $('#number_contract_aproved').hide();
                }

            });

            $('#marital_status').change(function() {
                var status = ($(this).val());

                console.log(status);

                if (status == 'married') {
                    $("#dados_conjuge-tab").show();
                } else if (status != 'married') {
                    $("#dados_conjuge-tab").hide();
                }
            });

            $('#is_pet').change(function() {
                var status = ($(this).val());

                if (status == 'yes') {
                    $("#type_pet").show();
                } else if (status != 'yes') {
                    $('#type_pet').hide();
                    $('#type_pet').val('');
                }
            });

            $('#type_work').change(function() {
                var status = ($(this).val());

                if (status == 'clt') {
                    $('#clt').show();
                    $('#pj').hide();
                } else if (status == 'pj') {
                    $('#pj').show();
                    $('#clt').hide();
                } else {
                    $('#pj').hide();
                    $('#clt').hide();
                }
            });

            $('#type_work_guarantor').change(function() {
                var status = ($(this).val());

                if (status == 'clt') {
                    $('#clt_guarantor').show();
                    $('#pj_guarantor').hide();
                } else if (status == 'pj') {
                    $('#pj_guarantor').show();
                    $('#clt_guarantor').hide();
                }
                // else {
                //     $('#pj_guarantor').hide();
                //     $('#clt_guarantor').hide();
                // }
            });

            $('#type_guarantor').change(function() {
                var status = ($(this).val());

                if (status == 'guarantor') {
                    $('#guarantor').show();
                    $('#type_work_guarantor_div').show();
                    $('#surety_bond').hide();
                } else if (status == 'surety_bond') {
                    $('#surety_bond').show();
                    $('#type_work_guarantor_div').hide();
                    $('#guarantor').hide();
                } else {
                    $('#surety_bond').hide();
                    $('#guarantor').hide();
                    $('#type_work_guarantor_div').hide();
                }
            });

            $('#is_aproved').change(function() {
                var status = ($(this).val());

                console.log(status);

                if (status == 'on_approval') {
                    $('#number_contract_aproved').hide();
                    $('#text_not_aproved').hide();
                } else if (status == 'approved') {
                    $('#number_contract_aproved').hide();
                    $('#text_not_aproved').hide();
                } else if (status == 'not_approved') {
                    $('#text_not_aproved').show();
                    $('#number_contract_aproved').hide();
                }
            });

            //AUTOCOMPLETE PROPERTIES
            var path = "{{ route('locatarios.autocomplete') }}";
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $("#autocomplete").autocomplete({
                source: function(request, response) {
                    // Fetch data
                    $.ajax({
                        url: path,
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            cod_propertie: request.term
                        },
                        success: function(data) {
                            $("#address").val(data.address);
                            $("#address_number").val(data.number_address);
                            $("#address_complement").val(data.number_address);
                            $("#code_postal").val(data.code_postal);
                            $("#district").val(data.district);
                            $("#city").val(data.city);
                            $("#uf").val(data.uf);
                            $("#type_propertie").val(data.type_propertie);
                            $("#object_propertie").val(data.object_propertie);
                        }
                    });
                },
            });

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
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="text-center mt-3 mb-5">Cadastro da Locação</h1>

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="dados_cadastrais-tab" data-toggle="tab"
                            data-target="#dados_cadastrais" type="button" role="tab" aria-controls="dados_cadastrais"
                            aria-selected="true">Dados Cadastrais</button>
                        <button class="nav-link" id="dados_locatario-tab" data-toggle="tab"
                            data-target="#dados_locatario" type="button" role="tab" aria-controls="dados_locatario"
                            aria-selected="false">Dados do Locátario</button>
                        <button class="nav-link" id="info_financeiras-tab" data-toggle="tab"
                            data-target="#info_financeiras" type="button" role="tab" aria-controls="info_financeiras"
                            aria-selected="false">Informações Financeiras Locatário</button>
                        <button class="nav-link" id="endereco_client-tab" data-toggle="tab"
                            data-target="#info_financeiras_fiador" type="button" role="tab"
                            aria-controls="info_financeiras_fiador" aria-selected="false">Informações Financeiras
                            Fiador</button>
                        <button class="nav-link" id="info_financeiras_fiador-tab" data-toggle="tab"
                            data-target="#status" type="button" role="tab" aria-controls="status"
                            aria-selected="false">Status</button>
                        <button class="nav-link" id="dados_conjuge-tab" data-toggle="tab" data-target="#dados_conjuge"
                            type="button" role="tab" aria-controls="dados_conjuge" aria-selected="false">Dados
                            Conjuge</button>
                        <button class="nav-link" id="salvar-tab" data-toggle="tab" data-target="#salvar" type="button"
                            role="tab" aria-controls="salvar" aria-selected="false">Ação</button>
                    </div>
                </nav>

                <form action="{{ route('locatarios.store') }}" method="post" enctype="multipart/form-data"
                    class="form">
                    @csrf

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="dados_cadastrais" role="tabpanel"
                            aria-labelledby="dados_cadastrais-tab">
                            <div class="row mt-5 mb-5">

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Código do Imóvel</label>
                                        <input type="text" id="autocomplete" name="cod_imovel" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tipo de Imóvel</label>
                                        <input type="text" name="type_propertie" id="type_propertie" class="form-control"
                                            disabled>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Objetivo de Imóvel</label>
                                        <input type="text" name="object_propertie" id="object_propertie"
                                            class="form-control" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>CEP</label>
                                        <input type="text" name="code_postal" id="code_postal" placeholder="00000-000"
                                            class="form-control" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label>Endereço</label>
                                        <input type="text" name="address" id="address" class="form-control" disabled>
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
                                        <input type="text" name="district" id="district" class="form-control" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Cidade</label>
                                        <input type="text" name="city" id="city" class="form-control" disabled>
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

                        <div class="tab-pane fade" id="dados_locatario" role="tabpanel"
                            aria-labelledby="endereco_client-tab">
                            <div class="row mt-5">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Nome</label>
                                        <input type="text" name="first_name" id="first_name" class="form-control"
                                            autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Sobrenome</label>
                                        <input type="text" name="last_name" id="last_name" class="form-control" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>CPF / CNPJ</label>
                                        <input type="text" name="cpf_cnpj" id="cpf_cnpj" class="form-control" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>RG</label>
                                        <input type="text" name="rg" id="rg" class="form-control" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>CNH</label>
                                        <input type="text" name="cnh" id="cnh" class="form-control" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>E-mail</label>
                                        <input type="text" name="mail" id="mail" class="form-control" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Sexo</label>
                                        <select class="custom-select" name="genre" id="genre">
                                            <option selected>Selecione...</option>
                                            @foreach ($genres as $genre)
                                                <option value="{{ $genre->slug }}"> {{ $genre->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Estado Civil</label>
                                        <select class="custom-select" name="marital_status" id="marital_status">
                                            <option selected>Selecione...</option>
                                            @foreach ($civil_states as $state)
                                                <option value="{{ $state->slug }}"> {{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Telefone</label>
                                        <input type="text" name="phone" id="phone" class="form-control" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Celular</label>
                                        <input type="text" name="celphone" id="celphone" class="form-control" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-3 mb-3">
                                    <hr>

                                    <h4 class="display-4 text-center">Dados Adicionais</h4>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Possui Filhos</label>
                                        <select class="custom-select" name="is_children" id="is_children">
                                            <option selected>Selecione...</option>
                                            <option value="yes">Sim</option>
                                            <option value="no">Não</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Possui Animais de Estimação</label>
                                        <select class="custom-select" name="is_pet" id="is_pet">
                                            <option selected>Selecione...</option>
                                            <option value="yes">Sim</option>
                                            <option value="no">Não</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4" id="type_pet">
                                    <div class="form-group">
                                        <label>Especificar Espécie</label>
                                        <input type="text" name="pet_species" id="pet_species" class="form-control"
                                            autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Quantidade de Moradores</label>
                                        <input type="number" min="1" name="number_residents" id="number_residents"
                                            class="form-control" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-3 mb-3">
                                    <hr>

                                    <h4 class="display-4 text-center">Endereço</h4>
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

                        <div class="tab-pane fade" id="info_financeiras" role="tabpanel"
                            aria-labelledby="endereco_client-tab">
                            <div class="row mt-5">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Tipo de Regime</label>
                                        <select class="custom-select" name="offices[type_work]" id="type_work">
                                            <option selected>Selecione...</option>
                                            <option value="clt">CLT</option>
                                            <option value="pj">PJ</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-12" id="clt">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Nome da Empresa</label>
                                                <input type="text" name="offices[company_name_clt]" class="form-control"
                                                    autofocus>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Cargo</label>
                                                <input type="text" name="offices[office]" class="form-control" autofocus>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Tempo de Registro</label>
                                                <input type="text" name="offices[registration_time]" class="form-control"
                                                    autofocus>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Renda Mensal</label>
                                                <input type="text" name="offices[rent_monthly]" class="form-control money"
                                                    autofocus>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>3 Ultimos comprovantes de renda</label>
                                                <input type="file" name="offices[image_file][]" class="form-control"
                                                    multiple>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Comprovante IRPF</label>
                                                <input type="file" name="offices[IRPF_file][]" class="form-control"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12" id="pj">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Razão Social</label>
                                                <input type="text" name="offices[company_name_pj]" class="form-control"
                                                    autofocus>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Endereço</label>
                                                <input type="file" name="offices[address_file]" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>CNPJ</label>
                                                <input type="file" name="offices[cnpj_file]" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Contrato Social</label>
                                                <input type="file" name="offices[contract_file]" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>3 Ultimos comprovantes de renda</label>
                                                <input type="file" name="offices[rent_file][]" class="form-control"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="info_financeiras_fiador" role="tabpanel"
                            aria-labelledby="endereco_client-tab">
                            <div class="row mt-5">
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

                        <div class="tab-pane fade" id="status" role="tabpanel" aria-labelledby="endereco_client-tab">
                            <div class="row mt-5">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Cadastro Aprovado</label>
                                        <select class="custom-select" name="is_aproved" id="is_aproved">
                                            <option selected>Selecione...</option>
                                            <option value="on_approval">Em Aprovação</option>
                                            <option value="approved">Aprovado</option>
                                            <option value="not_approved">Não Aprovado</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Dia do Vencimento</label>
                                        <input type="text" name="due_day" id="due_day" class="form-control" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-6" id="number_contract_aproved">
                                    <div class="form-group">
                                        <label>N° do Contrato</label>
                                        <input type="text" name="n_contract" id="n_contract" class="form-control"
                                            disabled>
                                    </div>
                                </div>

                                <div class="col-sm-12" id="text_not_aproved">
                                    <div class="form-group">
                                        <label>Texto</label>
                                        <textarea class="form-control" name="comments" id="mytextarea"
                                            rows="3"></textarea>
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
                                            class="form-control" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Sobrenome</label>
                                        <input type="text" name="last_name_partner" id="last_name_partner"
                                            class="form-control" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>CPF / CNPJ</label>
                                        <input type="text" name="cpf_cnpj_partner" id="cpf_cnpj_partner"
                                            class="form-control" autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>RG</label>
                                        <input type="text" name="rg_partner" id="rg_partner" class="form-control"
                                            autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>CNH</label>
                                        <input type="text" name="cnh_partner" id="cnh_partner" class="form-control"
                                            autofocus>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Certidão de Casamento</label>
                                        <input type="file" name="certification_married" id="certification_married"
                                            class="form-control" autofocus>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="salvar" role="tabpanel" aria-labelledby="salvar-tab">
                            <div class="col-sm-12 mt-5 mb-5">
                                <button class="btn btn-success btn-sm" type="submit">Cadastrar Locátario</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-sm-12 mt-5 text-right">
                <a class="btn btn-default btn-sm" href="{{ url('locatarios') }}">{{ __('<< Voltar para Listagem') }}</a>
            </div>
        </div>
    </div>
@endsection
