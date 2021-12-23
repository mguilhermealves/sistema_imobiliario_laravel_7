@extends('layouts.app')

@section('script')
    <script>
        $(function($) {

            $('form[name="form_create_payment"]').submit(function(event) {
                event.preventDefault();

                $("#gerar_pagamento").attr("disabled", true)

                $.ajax({
                    url: "{{ route('contas_receber.payment', $received->id) }}",
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(resp) {
                        if (resp.success == true) {
                            $('.message_box').removeClass('d-none').html(resp.message);

                            setTimeout(function() {

                                window.location.replace(
                                    ' {{ route('contas_receber') }}');
                            }, 1500);
                        } else {
                            // $('.message_box').html(resp.message).fadeIn( 300 ).delay( 1500 ).fadeOut( 400 );
                            console.log('nao rolou')
                        }
                    }
                });
            });

            $(document).ready(function() {

                $('#table-pagamentos').DataTable({
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

                $('#phone').mask("(99) 9999-9999");
                $('#celphone').mask("(99) 99999-9999");
                $('#code_postal').mask("99999-999");
                $('#cpf').mask("999.999.999-99");
                $('#cpf_partner').mask("999.999.999-99");
                $('.money').mask("#.##0,00", {
                    reverse: true
                });
                $('.percent').mask('##0,00%', {
                    reverse: true
                });

            });
        });
    </script>
@endsection

@section('content')

    <div class="alert alert-danger d-none message_box" role="alert">

    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="text-center mt-3 mb-5">Locatário - N° Contrato <strong>{{ $received->n_contract }} </strong>
                </h1>

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="dados_locacao-tab" data-toggle="tab" data-target="#dados_locacao"
                            type="button" role="tab" aria-controls="dados_locacao" aria-selected="true">Dados da
                            Locação</button>
                        <button class="nav-link" id="pagamentos-tab" data-toggle="tab" data-target="#pagamentos"
                            type="button" role="tab" aria-controls="pagamentos" aria-selected="false">Pagamentos</button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="dados_locacao" role="tabpanel"
                        aria-labelledby="dados_cadastrais-tab">
                        <div class="row">

                            <div class="col-sm-12 mt-5 mb-5">
                                <p class="h1 text-center">Dados do Cliente</p>
                            </div>

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

                            <div class="col-sm-12 mt-5 mb-5">
                                <hr>
                                <p class="h1 text-center">Dados da Locação</p>
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
                                        class="form-control" value="{{ $received->propertie['complement'] }}" disabled>
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

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Valor da {{ $obj_propertie }}</label>
                                    <input type="text" name="value_propertie" id="value_propertie"
                                        class="form-control money" value="{{ $value_propertie }}" disabled>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Dia do Vencimento</label>
                                    <input type="text" name="due_day" id="due_day" class="form-control"
                                        value="{{ $received['day_due'] }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pagamentos" role="tabpanel" aria-labelledby="endereco_client-tab">
                        <div class="row mt-5">
                            <div class="col-sm-12 text-right mt-5 mb-5">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                    data-target="#modelNewPayment" data-backdrop="static" data-keyboard="false">
                                    Novo Pagamento
                                </button>
                            </div>
                            <div class="col-sm-12">

                                <h1 class="text-center mb-5">Lista de Pagamentos</h1>

                                <table class="table table-striped table-inverse" id="table-pagamentos">
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
                                        @forelse ($payments as $payment)
                                            <tr>
                                                <td scope="row">{{ $payment->id }}</td>
                                                <td>{{ $payment->payment_method }}</td>
                                                <td>{{ $payment->amount }}</td>
                                                <td>
                                                    @if ($payment->status_payment == 'to_win')
                                                        {{ 'Aguardando Pagamento' }}
                                                    @elseif ($payment->status_payment == 'paid')
                                                        {{ 'Pago' }}
                                                    @else
                                                        {{ 'Não Pago' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('contas_receber.edit', $payment->id) }}"
                                                        type="button" class="btn btn-primary btn-sm">Visualizar</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <th colspan="6" style="text-align: center">Nenhum pagamento criado até o
                                                    momento...
                                                </th>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Modal New Payment -->
                        <div class="modal fade" id="modelNewPayment" tabindex="-1" role="dialog"
                            aria-labelledby="modelTitleId" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Gerar Pagamento Ref. ao Locátario - N° Contrato
                                            <strong>{{ $received->n_contract }} </strong>
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <form name="form_create_payment" enctype="multipart/form-data"
                                                        class="form">
                                                        @csrf

                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label>Descrição do Imóvel</label>
                                                                    <input type="text" name="obj_propertie"
                                                                        id="obj_propertie" class="form-control"
                                                                        value="{{ $received->propertie['object_propertie'] }}"
                                                                        disabled>
                                                                    <input type="hidden" name="obj_propertie"
                                                                        id="obj_propertie" class="form-control"
                                                                        value="{{ $received->propertie['object_propertie'] }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>Dia do Vencimento</label>
                                                                    <input type="text" name="due_day" id="due_day"
                                                                        class="form-control"
                                                                        value="{{ $received['day_due'] }}" disabled>
                                                                    <input type="hidden" name="due_day" id="due_day"
                                                                        class="form-control"
                                                                        value="{{ $received['day_due'] }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>Juros</label>
                                                                    <input type="text" name="fees" id="fees"
                                                                        class="form-control percent" value="1.00%" disabled>
                                                                    <input type="hidden" name="fees" id="fees"
                                                                        class="form-control" value="1.00%">
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>Multa</label>
                                                                    <input type="text" name="fine" id="fine"
                                                                        class="form-control percent" value="1.00%"
                                                                        disabled>
                                                                    <input type="hidden" name="fine" id="fine"
                                                                        class="form-control" value="1.00%">
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <label>Valor</label>
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"
                                                                            id="basic-addon1">R$</span>
                                                                    </div>
                                                                    <input type="text" name="amount" id="amount"
                                                                        class="form-control money"
                                                                        value="{{ $value_propertie }}" disabled>
                                                                    <input type="hidden" name="amount" id="amount"
                                                                        class="form-control money"
                                                                        value="{{ $value_propertie }}">
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <label>Forma de Pagamento</label>
                                                                    <select class="custom-select" name="payment_method">
                                                                        <option selected>Selecione...</option>
                                                                        <option value="debit">Débito em conta</option>
                                                                        <option value="ticket">Boleto</option>
                                                                        <option value="transfer">Transferência</option>
                                                                        <option value="pix">PIX</option>
                                                                        <option value="cheque">Cheque</option>
                                                                        <option value="others">Outros</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-12 mt-5 mb-5 text-right">
                                                                <button class="btn btn-success btn-sm" id="gerar_pagamento"
                                                                    type="submit">Gerar
                                                                    Pagamento</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary btn-sm"
                                            data-dismiss="modal">Fechar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 mt-5 text-right">
                <a class="btn btn-default btn-sm"
                    href="{{ url('contas_receber') }}">{{ __('<< Voltar para Listagem') }}</a>
            </div>
        </div>
    </div>
@endsection
