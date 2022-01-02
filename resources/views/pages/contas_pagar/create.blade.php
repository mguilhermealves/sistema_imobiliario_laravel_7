@extends('layouts.app')

@section('script')
    <script>
        $(function($) {

            //AUTOCOMPLETE PROPERTIES
            var path = "{{ route('contas_pagar.contas.autocomplete') }}";
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
                            $("#category").val(data.name_category);
                            $("#type").val(data.type_category);
                        }
                    });
                },
            });

            $('form[name="form_create_account_pay"]').submit(function(event) {
                event.preventDefault();

                $.ajax({
                    url: "{{ route('contas_pagar.contas.store') }}",
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(resp) {
                        if (resp.error === false) {
                            $('.message_box').removeClass('d-none').addClass('alert-success').html(resp.message);

                            setTimeout(function() {
                                window.location.replace(' {{ route('contas_pagar') }}');
                            }, 1500);
                        } else {
                            $('.message_box').removeClass('d-none').addClass('alert-danger').html(resp.message);
                        }
                    }
                });
            });

            $(document).ready(function() {

                $('.money').mask("#.##0,00", {
                    reverse: true
                });

                var status = ($('#is_recorrency').val());

                if (status == 'yes') {
                    $("#show_day_due").show();
                } else {
                    $("#show_day_due").hide();
                }
            });

            $('#is_recorrency').change(function() {
                var status = ($(this).val());

                if (status == 'yes') {
                    $("#show_day_due").show();
                } else {
                    $("#show_day_due").hide();
                }
            });
        });
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="alert d-none message_box" role="alert">

        </div>
        <div class="row">
            <div class="col-sm-12">
                <h1 class="text-center mt-3 mb-5">Cadastro de Contas à Pagar</h1>

                <form name="form_create_account_pay" enctype="multipart/form-data"
                    class="form">
                    @csrf

                    <div class="row mt-5">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Empresa Beneficiária</label>
                                <input type="text" name="company_beneficiary" id="company_beneficiary" class="form-control" autofocus>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Centro de Custo</label>
                                <input type="text" name="center_count" id="autocomplete" class="form-control" autofocus>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Categoria</label>
                                <input type="text" name="category" id="category" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Tipo</label>
                                <input type="text" name="type" id="type" class="form-control" disabled>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Valor (R$)</label>
                                <input type="text" name="amount" id="amount" class="form-control money" autofocus>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Conta Recorrente</label>
                                <select class="custom-select" name="is_recorrency" id="is_recorrency">
                                    <option selected>Selecione...</option>
                                    <option value="yes">Sim</option>
                                    <option value="no">Nao</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4" id="show_day_due">
                            <div class="form-group">
                                <label>Dia</label>
                                <input type="number" name="day_due" id="day_due" min="0" max="31" class="form-control" autofocus>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Forma de Pagamento</label>
                                <select class="custom-select" name="payment_method" required>
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

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Observação</label>
                                <textarea class="form-control" name="comments" id="comments" rows="5" style="resize: none;"></textarea>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary btn-sm">Cadastrar Conta</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-sm-12 mt-5 text-right">
                <a class="btn btn-default btn-sm" href="{{ url('clientes') }}">{{ __('<< Voltar para Listagem') }}</a>
            </div>
        </div>
    </div>
@endsection
