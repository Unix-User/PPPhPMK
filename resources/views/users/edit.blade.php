@extends('layouts.default')

@section('title' , 'Editar usuário')

@push('styles')
<!-- Adicionando JQuery    -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endpush

@section('content')
<header class="major">
    <h2>Editar usuário</h2>
    <p>Aqui você pode editar os dados do usuário</p>
</header>

@if ($errors->any())
<div style="width: 100%; position: relative; background-color: #272833; border-color: #843534" class="alert alert-danger alert-dismissable" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    @foreach ($errors->all() as $error)
    <i class="icon fa-exclamation-triangle"></i> {{ $error }} <br />
    @endforeach
</div>
@endif
<section>
    <div class="panel-body">
        <form action="/user/{{ $user->id }}/update" method="POST">
            @csrf
            @method('POST')
            <div class="form-group row">
                <div class="@if($errors->has('name')) has-error @endif col-md-3 col-md-offset-0">
                    <label for="name">Usuário</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" />
                    @if($errors->has('name'))
                    <span class="help-block">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div class="@if($errors->has('password')) has-error @endif col-md-3 col-md-offset-0">
                    <label for="password">Senha</label>
                    <input type="password" name="password" id="password" class="form-control" value="" placeholder="Digite para alterar" />
                    @if($errors->has('password'))
                    <span class="help-block">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="@if($errors->has('phone')) has-error @endif col-md-3 col-md-offset-0">
                    <label for="phone">Telefone</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone }}" />
                    @if($errors->has('phone'))
                    <span class="help-block">{{ $errors->first('phone') }}</span>
                    @endif
                </div>
                <div class="@if($errors->has('product_id')) has-error @endif col-md-3 col-md-offset-0">
                    <label for="product_id">Plano</label>
                    <div class="select-wrapper">
                        <select name="product_id[]" class="form-control" placeholder="Selecione um plano">
                            @if(count($products) == 0)
                            <option value="">Nenhum plano cadastrado</option>
                            @else
                            @foreach($products as $product)
                            <option value="{{ $product->id }}" @if(isset($user->contracts->first()->product_id) == $product->id) selected @endif>{{ $product->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="@if($errors->has('email')) has-error @endif col-md-12 col-md-offset-0">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" />
                    @if($errors->has('email'))
                    <span class="help-block">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="@if($errors->has('cep')) has-error @endif col-md-3 col-md-offset-0">
                    <label for="cep">CEP</label>
                    <input type="text" name="cep" id="cep" class="form-control" value="{{ $user->cep }}" />
                    @if($errors->has('cep'))
                    <span class="help-block">{{ $errors->first('cep') }}</span>
                    @endif
                </div>
                <div class="@if($errors->has('rua')) has-error @endif col-md-3 col-md-offset-0">
                    <label for="rua">Rua</label>
                    <input type="text" name="rua" id="rua" class="form-control" value="{{ $user->rua }}" />
                    @if($errors->has('rua'))
                    <span class="help-block">{{ $errors->first('rua') }}</span>
                    @endif
                </div>
                <div class="@if($errors->has('bairro')) has-error @endif col-md-3 col-md-offset-0">
                    <label for="bairro">Bairro</label>
                    <input type="text" name="bairro" id="bairro" class="form-control" value="{{ $user->bairro }}" />
                    @if($errors->has('bairro'))
                    <span class="help-block">{{ $errors->first('bairro') }}</span>
                    @endif
                </div>
                <div class="@if($errors->has('cidade')) has-error @endif col-md-3 col-md-offset-0">
                    <label for="cidade">Cidade</label>
                    <input type="text" name="cidade" id="cidade" class="form-control" value="{{ $user->cidade }}" />
                    @if($errors->has('cidade'))
                    <span class="help-block">{{ $errors->first('cidade') }}</span>
                    @endif
                </div>
                <div class="form-group @if($errors->has('uf')) has-error @endif col-md-3 col-md-offset-0">
                    <label for="uf">Estado</label>
                    <input type="text" name="uf" id="uf" class="form-control" value="{{ $user->uf }}" />
                    @if($errors->has('uf'))
                    <span class="help-block">{{ $errors->first('uf') }}</span>
                    @endif
                </div>
                <div class="form-group @if($errors->has('num')) has-error @endif col-md-3 col-md-offset-0">
                    <label for="num">Número</label>
                    <input type="text" name="num" id="num" class="form-control" value="{{ $user->num }}" />
                    @if($errors->has('num'))
                    <span class="help-block">{{ $errors->first('num') }}</span>
                    @endif
                </div>
                <div class="form-group @if($errors->has('etc')) has-error @endif col-md-3 col-md-offset-0">
                    <label for="etc">Complemento</label>
                    <input type="text" name="etc" id="etc" class="form-control" value="{{ $user->etc }}" />
                    @if($errors->has('etc'))
                    <span class="help-block">{{ $errors->first('etc') }}</span>
                    @endif
                </div>
                <div class="form-group col-md-3 col-md-offset-0">
                    <label for="footer">Tec. responsável: </label>
                    <input type="hidden" name="owner" class="form-control" value="" />
                    <ul name="footer" class="actions">
                        <li><a href="/users" class="button special small">Cancelar</a></li>
                        <li><button type="submit" class="button small">Salvar</button></li>
                    </ul>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<!-- Adicionando Javascript -->
<script>
    $(document).ready(function() {

        function limpa_formulário_cep() {
            // Limpa valores do formulário de cep.
            $("#rua").val("");
            $("#bairro").val("");
            $("#cidade").val("");
            $("#uf").val("");
            $("#ibge").val("");
        }

        //Quando o campo cep perde o foco.
        $("#cep").blur(function() {

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
    });
</script>
@endpush