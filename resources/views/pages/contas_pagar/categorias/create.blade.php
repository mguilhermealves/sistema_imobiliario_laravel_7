@extends('layouts.app')

@section('script')
    <script>
        $(function($) {
            $('form[name="form_create_category"]').submit(function(event) {
                event.preventDefault();

                $.ajax({
                    url: "{{ route('contas_pagar.categoria.store') }}",
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(resp) {
                        if (resp.error === false) {
                            $('.message_box').removeClass('d-none').addClass('alert-success').html(resp.message);

                            setTimeout(function() {
                                window.location.replace(' {{ route('contas_pagar_categoria') }}');
                            }, 1500);
                        } else {
                            $('.message_box').removeClass('d-none').addClass('alert-danger').html(resp.message);
                        }
                    }
                });
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
                <h1 class="text-center mt-3 mb-5">Cadastro de Categorias</h1>

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="dados_cadastrais-tab" data-toggle="tab"
                            data-target="#dados_cadastrais" type="button" role="tab" aria-controls="dados_cadastrais"
                            aria-selected="true">Dados Cadastrais</button>
                    </div>
                </nav>

                <form name="form_create_category" enctype="multipart/form-data"
                    class="form">
                    @csrf

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="dados_cadastrais" role="tabpanel"
                            aria-labelledby="dados_cadastrais-tab">
                            <div class="row mt-5">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Nome</label>
                                        <input type="text" name="name_category" id="name_category" class="form-control"
                                            autofocus required>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Tipo</label>
                                        <input type="text" name="type_category" id="type_category" class="form-control"
                                            autofocus required>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Centro de Custo</label>
                                        <input type="number" name="cost_center_category" id="center_category"
                                            class="form-control" autofocus required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-5 mb-5">
                            <button class="btn btn-success btn-sm" type="submit">Cadastrar Categoria</button>
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
