@extends('layouts.app')

@section('script')
    <script>
        $(function($) {

            $('form[name="form_update_account_pay"]').submit(function(event) {
                event.preventDefault();

                var formData = new FormData($(this)[0]);

                $.ajax({
                    url: "{{ route('contas_pagar.update', $account_pay->id) }}",
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
                                window.location.replace(
                                    "{{ route('contas_pagar.show', $account_pay->id) }}"
                                );
                            }, 1500);
                        } else {
                            $('.message_box').removeClass('d-none').addClass('alert-danger')
                                .html(resp.message);
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
    <div class="alert d-none message_box" role="alert">

    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">

                <div class="col-sm-12">
                    <h1 class="text-center mt-3 mb-5">Cadastro de Contas à Pagar</h1>

                    <form name="form_update_account_pay" enctype="multipart/form-data" class="form">
                        @method('PUT')
                        @csrf

                        <div class="row mt-5">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Empresa Beneficiária</label>
                                    <input type="text" name="company_beneficiary" id="company_beneficiary"
                                        value="{{ $account_pay['company_beneficiary'] }}" class="form-control"
                                        autofocus>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Centro de Custo</label>
                                    <input type="text" name="center_count" id="autocomplete" class="form-control"
                                        value="{{ $account_pay['account_category_id'] }}" autofocus>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Categoria</label>
                                    <input type="text" name="category" id="category" class="form-control"
                                        value="{{ $account_pay->category['name_category'] }}" disabled>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Tipo</label>
                                    <input type="text" name="type" id="type" class="form-control"
                                        value="{{ $account_pay->category['type_category'] }}" disabled>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Valor (R$)</label>
                                    <input type="text" name="amount" id="amount" class="form-control money"
                                        value="{{ $account_pay['amount'] }}" autofocus>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Conta Recorrente</label>
                                    <select class="custom-select" name="is_recorrency" id="is_recorrency">
                                        <option value="yes" {{ $account_pay->is_recorrency == 'yes' ? 'selected' : '' }}>
                                            Sim
                                        </option>
                                        <option value="no" {{ $account_pay->is_recorrency == 'no' ? 'selected' : '' }}>
                                            Não
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-4" id="show_day_due">
                                <div class="form-group">
                                    <label>Dia</label>
                                    <input type="number" name="day_due" id="day_due" min="0" max="31" class="form-control"
                                        value="{{ $account_pay['day_due'] }}" autofocus>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Forma de Pagamento</label>
                                    <select class="custom-select" name="payment_method" required>
                                        <option value="debit"
                                            {{ $account_pay->payment_method == 'debit' ? 'selected' : '' }}>Débito em
                                            conta
                                        </option>
                                        <option value="ticket"
                                            {{ $account_pay->payment_method == 'ticket' ? 'selected' : '' }}>Boleto
                                        </option>
                                        <option value="transfer"
                                            {{ $account_pay->payment_method == 'transfer' ? 'selected' : '' }}>
                                            Transferência
                                        </option>
                                        <option value="pix"
                                            {{ $account_pay->payment_method == 'pix' ? 'selected' : '' }}>PIX
                                        </option>
                                        <option value="cheque"
                                            {{ $account_pay->payment_method == 'cheque' ? 'selected' : '' }}>Cheque
                                        </option>
                                        <option value="others"
                                            {{ $account_pay->payment_method == 'others' ? 'selected' : '' }}>Outros
                                        </option>
                                    </select>
                                </div>
                            </div>

                            @can('admin')
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" name="status" id="">
                                            <option {{ $account_pay->status_payment == 'to_win' ? 'selected' : '' }}
                                                value="paid">A Pagar</option>
                                            <option {{ $account_pay->status_payment == 'paid' ? 'selected' : '' }} value="paid">
                                                Pago</option>
                                            <option {{ $account_pay->status_payment == 'loser' ? 'selected' : '' }}
                                                value="loser">Vencido</option>
                                            <option {{ $account_pay->status_payment == 'judicial' ? 'selected' : '' }}
                                                value="judicial">Juridico</option>
                                            <option {{ $account_pay->status_payment == 'according_to' ? 'selected' : '' }}
                                                value="according_to">Em Acordo</option>
                                        </select>
                                    </div>
                                </div>
                            @endcan

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Observação</label>
                                    <textarea class="form-control" name="comments" id="comments" rows="5"
                                        value="{{ $account_pay->comments }}" style="resize: none;"></textarea>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary btn-sm">Editar Pagamento</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
