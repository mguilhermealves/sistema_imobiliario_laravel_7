@extends('layouts.app')

@section('script')
    <script>
        $('#exampleModal').on('show.bs.modal', event => {
            var button = $(event.relatedTarget);
            var modal = $(this);
            // Use above variables to manipulate the DOM

        });

        $(function($) {

            $('form[name="form_edit_payment"]').submit(function(event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Tem Certeza que deseja alterar esse pagamento?',
                    text: "Você não poderá reverter isso!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim',
                    cancelButtonText: "Não",
                }).then((result) => {
                    if (result.isConfirmed) {
                        event.preventDefault();
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            url: "{{ route('contas_receber.payment_edit', $payment->id) }}",
                            type: 'POST',
                            data: $(this).serialize(),
                            dataType: 'json',
                            success: function(resp) {
                                if (resp.error == false) {
                                    $("#editar_pagamento").attr("disabled", true)
                                    $('.message_box').removeClass('d-none').html(resp
                                        .message);

                                    setTimeout(function() {

                                        window.location.replace(
                                            "{{ route('contas_receber.edit', $payment->id) }}"
                                        );
                                    }, 1500);
                                } else {
                                    $('.message_box').removeClass('d-none').html(resp
                                        .message).fadeIn(300).delay(2000).fadeOut(
                                        600);
                                    $("#editar_pagamento").attr("enabled", true)
                                }
                            }
                        });
                    }
                });
            });

            $('form[name="form_send_mail_ticket"]').submit(function(event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Tem Certeza que deseja enviar o boleto por e-mail?',
                    text: "O cliente receberá o email dentro de até 30 minutos após o envio.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim',
                    cancelButtonText: "Não",
                }).then((result) => {
                    if (result.isConfirmed) {
                        event.preventDefault();
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            url: "{{ route('contas_receber.send_email', $payment->id) }}",
                            type: 'POST',
                            data: $(this).serialize(),
                            dataType: 'json',
                            success: function(resp) {
                                if (resp.error == false) {
                                    $("#editar_pagamento").attr("disabled", true)
                                    $('.message_box').removeClass('d-none').html(resp
                                        .message);

                                    // setTimeout(function() {

                                    //     window.location.replace(
                                    //         "{{ route('contas_receber.edit', $payment->id) }}"
                                    //     );
                                    // }, 1500);
                                } else {
                                    $('.message_box').removeClass('d-none').html(resp
                                        .message).fadeIn(300).delay(2000).fadeOut(
                                        600);
                                    $("#editar_pagamento").attr("enabled", true)
                                }
                            }
                        });
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
                $('.percent').mask('##0.00%', {
                    reverse: true
                });

            });
        });
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-12 mt-5 mb-5">
                    <p class="h1 text-center">Dados do Pagamento - N° {{ $payment->id }}</p>
                </div>

                @can('admin')
                    <div class="col-sm-12 mb-5 text-right">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                            data-target="#modal_edit_payment">
                            Editar Pagamento
                        </button>
                    </div>
                @endcan

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Status</label>
                            <input type="text" name="" id="" class="form-control"
                                value="{{ $status_payment }}" disabled>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Método de Pagamento</label>
                            <input type="text" name="" id="" class="form-control"
                                value="{{ $payment['payment_method'] }}" disabled>
                        </div>
                    </div>

                    @if ($payment['payment_method'] == 'ticket')

                        @if ($dias_em_atraso->invert == -1)
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Dias em Atraso</label>
                                    <input type="text" class="form-control" name="" id="" value="{{ $dias_em_atraso->days }}"
                                        disabled
                                        style="color: green; background-color: rgb(178, 253, 193); font-weight: bold;">
                                </div>
                            </div>
                        @else
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Dias em Atraso</label>
                                    <input type="text" class="form-control" name="" id=""
                                        value="{{ $dias_em_atraso->days }}" disabled
                                        style="color: red; background-color: rgb(255, 192, 192); font-weight: bold;">
                                </div>
                            </div>
                        @endif

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Data do Vencimento do Boleto</label>
                                <input type="text" name="" id="" class="form-control"
                                    value="{{ date('d/m/Y', strtotime($payment->historic_bank['expire_at'])) }}"
                                    disabled>
                            </div>
                        </div>
                    @endif

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Juros</label>
                            <input type="text" name="fees" id="fees" class="form-control percent"
                                value="{{ $payment['fees'] }}" disabled>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Multa</label>
                            <input type="text" name="fine" id="fine" class="form-control percent"
                                value="{{ $payment['fine'] }}" disabled>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <label>Valor</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">R$</span>
                            </div>
                            <input type="text" name="amount" id="amount" class="form-control money"
                                value="{{ $payment['amount'] }}" disabled>
                        </div>
                    </div>

                    @if ($payment['payment_method'] == 'ticket')

                        <div class="col-sm-12" style="overflow: scroll;">
                            <p class="lead text-muted text-center">
                                Historico
                            </p>
                            <table class="table table-striped table-inverse">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>Data</th>
                                        <th>Mensagem</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($json_historical_bank[0] as $history)
                                        <tr>
                                            <td scope="row">
                                                {{ date('d/m/Y h:i:s', strtotime($history->created_at)) }}</td>
                                            <td>{{ $history->message }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Boleto</label>
                                <iframe class="pdf" src="{{ $payment['historic_bank']['pdf'] }}" width="100%"
                                    height="400px"></iframe>
                                <a href="{{ $payment['historic_bank']['pdf'] }}" download target="_blank">Download</a>
                            </div>
                        </div>

                        <div class="col-sm-12 text-right">
                            <form name="form_send_mail_ticket" enctype="multipart/form-data" class="form">
                                @csrf
                                <input type="hidden" name="id" value="{{ $payment->tenant_id }}">
                                <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                                <button type="submit" class="btn btn-primary btn-sm">Reenviar E-mail</button>
                            </form>

                        </div>
                    @endif

                    {{-- @if ($payment['payment_method'] != 'ticket')
                        <div class="col-sm-12">
                            <a class="btn btn-primary btn-sm" href="http://">Gerar Recibo</a>
                        </div>
                    @endif --}}

                    <!-- Modal -->
                    <div class="modal fade" id="modal_edit_payment" tabindex="-1" role="dialog"
                        aria-labelledby="modelTitleId" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-lg" role="document">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar Pagamento - N° {{ $payment->id }} </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="alert alert-danger d-none message_box" role="alert">

                                                </div>
                                                <form name="form_edit_payment" enctype="multipart/form-data"
                                                    class="form">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $payment->id }}">

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Vencimento</label>
                                                                <input type="number" class="form-control" name="day_due"
                                                                    id="" min="0" max="31" required>
                                                            </div>
                                                        </div>

                                                        @if ($payment['payment_method'] != 'ticket')
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label>Status</label>
                                                                    <select class="form-control" name="status" id="">
                                                                        <option value="" selected>Selecione...</option>
                                                                        <option value="paid">Pago</option>
                                                                        <option value="loser">Vencido</option>
                                                                        <option value="judicial">Juridico</option>
                                                                        <option value="according_to">Em Acordo</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <div class="col-sm-12 text-right">
                                                            <a href="{{ route('locatarios.show', $payment['tenant_id']) }}"
                                                                target="_blank">Editar Dados do
                                                                Locátario</a>
                                                        </div>

                                                        <div class="col-sm-12">
                                                            <button type="submit" class="btn btn-primary btn-sm"
                                                                id="editar_pagamento">Editar</button>
                                                        </div>

                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm"
                                        data-dismiss="modal">Fechar</button>

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 mt-5 text-right">
                        <a class="btn btn-default btn-sm"
                            href="{{ url()->previous() }}">{{ __('<< Voltar para Listagem') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
