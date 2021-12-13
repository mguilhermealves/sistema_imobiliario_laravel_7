@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="text-center mt-3 mb-5">Efetuar Pagamento Ref. ao Locátario N° <strong>{{ $received->id }} </strong>
                </h1>


                <form action="{{ route('contas_receber.payment') }}" method="post" enctype="multipart/form-data"
                    class="form">
                    @csrf
                    <div class="row mt-5">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Descrição do Imóvel</label>
                                <input type="text" name="uf" id="uf" class="form-control"
                                    value="{{ $received->propertie['object_propertie'] }}" disabled>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="custom-select" name="status_payment">
                                    <option selected>Selecione...</option>
                                    <option value="to_win">A Vencer</option>
                                    <option value="loser">Vencido</option>
                                    <option value="paid">Pago</option>
                                    <option value="according_to">Em Acordo</option>
                                    <option value="judicial">Juridico</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Data de Vencimento</label>
                                <input type="date" name="due_date" id="due_date" class="form-control" autofocus>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Juros</label>
                                <input type="number" min="1" name="fees" id="fees" class="form-control" autofocus>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label>Multa</label>
                                <input type="number" min="1" name="fine" id="fine" class="form-control" autofocus>
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

                        <div class="col-sm-12 mt-5 mb-5">
                            <button class="btn btn-success btn-sm" type="submit">Cadastrar Pagamento</button>
                        </div>
                    </div>
                </form>

            </div>

            <div class="col-sm-12 mt-5 text-right">
                <a class="btn btn-default btn-sm"
                    href="{{ url('contas_receber') }}">{{ __('Voltar para Listagem') }}</a>
            </div>
        </div>
    </div>
@endsection
