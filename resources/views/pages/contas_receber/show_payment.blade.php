@extends('layouts.app')

@section('script')
    <script>
        $(function($) {

            // $('#disparar_email').click(function(event) {
            //     event.preventDefault();

            //     $.ajax({
            //         url: "{{ route('contas_receber.payment', $received->id) }}",
            //         type: 'POST',
            //         data: $(this).serialize(),
            //         dataType: 'json',
            //         success: function(resp) {
            //             if (resp.success == true) {
            //                 $('.message_box').removeClass('d-none').html(resp.message);

            //                 setTimeout(function() {

            //                     window.location.replace(
            //                         ' {{ route('contas_receber') }}');
            //                 }, 1500);
            //             } else {
            //                 // $('.message_box').html(resp.message).fadeIn( 300 ).delay( 1500 ).fadeOut( 400 );
            //                 console.log('nao rolou')
            //             }
            //         }
            //     });
            // });

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
                    <p class="h1 text-center">Dados do Pagamento - {{ $payment->id }}</p>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Status</label>
                            <input type="text" name="" id="" class="form-control"
                                value="{{ $payment['status_payment'] }}" disabled>
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
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Data do Vencimento do Boleto</label>
                                <input type="text" name="" id="" class="form-control" value="{{ $payment['day_due'] }}"
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

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Boleto</label>
                                <iframe class="pdf" src="{{ $payment['historic_bank']['pdf'] }}" width="100%"
                                    height="400px"></iframe>
                                <a href="{{ $payment['historic_bank']['pdf'] }}" download target="_blank">Download</a>
                            </div>
                        </div>
                    @endif

                    <div class="col-sm-12 mt-5 text-right">
                        <a class="btn btn-default btn-sm"
                            href="{{ url()->previous() }}">{{ __('<< Voltar para Listagem') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
