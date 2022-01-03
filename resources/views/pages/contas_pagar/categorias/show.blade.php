@extends('layouts.app')

@section('script')
    <script>
        $(function($) {
            $('form[name="form_update_category"]').submit(function(event) {
                event.preventDefault();

                $.ajax({
                    url: "{{ route('contas_pagar.categoria.update', $account_category->id) }}",
                    type: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(resp) {
                        if (resp.error === false) {
                            $('.message_box').removeClass('d-none').addClass('alert-success')
                                .html(resp.message);

                            setTimeout(function() {
                                window.location.replace(
                                    "{{ route('contas_pagar.categoria.show', $account_category->id) }}"
                                );
                            }, 1500);
                        } else {
                            $('.message_box').removeClass('d-none').addClass('alert-danger')
                                .html(resp.message);
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

                <form name="form_update_category" enctype="multipart/form-data" class="form">
                    @method('PUT')
                    @csrf

                    <div class="row mt-5">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" name="name_category" id="name_category" class="form-control"
                                    value="{{ $account_category->name_category }}" autofocus>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Tipo</label>
                                <input type="text" name="type_category" id="type_category" class="form-control"
                                    value="{{ $account_category->type_category }}" autofocus>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label>Centro de Custo</label>
                                <input type="number" name="cost_center_category" id="center_category"
                                    value="{{ $account_category->cost_center_category }}" class="form-control" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 mt-5 mb-5">
                        <button class="btn btn-success btn-sm" type="submit">Editar Categoria</button>
                    </div>
                </form>
            </div>

            <div class="col-sm-12 mt-5 text-right">
                <a class="btn btn-default btn-sm" href="{{ url('clientes') }}">{{ __('<< Voltar para Listagem') }}</a>
            </div>
        </div>
    </div>
@endsection
