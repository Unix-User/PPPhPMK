@extends('layouts.default')

@section('title' , 'Criar usuário')

@push('styles')
<!-- Adicionando JQuery    -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endpush


@section('content')
<header class="major">
    <h2>Regisrar novo usuário</h2>
    <p>Página para registro de usuário</p>
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
        <form action="/user/store" method="post" accept-charset="utf-8" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <div class="@if($errors->has('name')) has-error @endif col-md-3 col-md-offset-0">
                    <label for="title">Usuário</label>
                    <input type="text" name="name" class="form-control" value="@if(old('name')){{ old('name') }}@endif" placeholder="Usuário" />
                    @if($errors->has('name'))
                    <span class="help-block">@foreach($errors->get('name') as $error){{ $error }}@endforeach</span>
                    @endif
                </div>
                <div class=" @if($errors->has('password')) has-error @endif col-md-3 col-md-offset-0">
                    <label for="title">Senha</label>
                    <input type="password" name="password" class="form-control" value="@if(old('password')){{ old('password') }}@endif" placeholder="Senha" />
                    @if($errors->has('password'))
                    <span class="help-block">@foreach($errors->get('password') as $error){{ $error }}@endforeach</span>
                    @endif
                </div>
                <div class=" @if($errors->has('phone')) has-error @endif col-md-3 col-md-offset-0">
                    <label for="title">Telefone</label>
                    <input type="text" name="phone" class="form-control" value="@if(old('phone')){{ old('phone') }}@endif" placeholder="Telefone" />
                    @if($errors->has('phone'))
                    <span class="help-block">@foreach($errors->get('phone') as $error){{ $error }}@endforeach</span>
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
                            <option value="{{ $product->id }}" @if(old('product_id')==$product->id) selected @endif>{{ $product->user->id }} - {{ $product->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class=" @if($errors->has('email')) has-error @endif col-md-12 col-md-offset-0">
                    <label for="title">Email</label>
                    <input type="email" name="email" class="form-control" value="@if(old('email')){{ old('email') }}@endif" placeholder="Email" />
                    @if($errors->has('email'))
                    <span class="help-block">@foreach($errors->get('email') as $error){{ $error }}@endforeach</span>
                    @endif
                </div>
                <div class="@if($errors->has('cep')) has-error @endif col-md-3 col-md-offset-0">
                    <label for="cep">Cep:</label>
                    <input name="cep" type="text" id="cep" class="form-control" size="10" maxlength="9" onblur="pesquisacep(this.value);" value="@if(old('cep')){{ old('cep') }}@endif" placeholder="Cep" />
                    @if($errors->has('cep'))
                    <span class="help-block">@foreach($errors->get('cep') as $error){{ $error }}@endforeach</span>
                    @endif
                </div>
                <div class="@if($errors->has('rua')) has-error @endif col-md-3 col-md-offset-0">
                    <label for="rua">Rua:</label>
                    <input name="rua" type="text" class="form-control" id="rua" size="60" value="@if(old('rua')){{ old('rua') }}@endif" placeholder="Rua" />
                    @if($errors->has('rua'))
                    <span class="help-block">@foreach($errors->get('rua') as $error){{ $error }}@endforeach</span>
                    @endif
                </div>
                <div class="@if($errors->has('bairro')) has-error @endif col-md-3 col-md-offset-0">
                    <label>Bairro:</label>
                    <input name="bairro" type="text" class="form-control" id="bairro" size="40" value="@if(old('bairro')){{ old('bairro') }}@endif" placeholder="Bairro" />
                    @if($errors->has('bairro'))
                    <span class="help-block">@foreach($errors->get('bairro') as $error){{ $error }}@endforeach</span>
                    @endif
                </div>
                <div class="@if($errors->has('cidade')) has-error @endif col-md-3 col-md-offset-0">
                    <label for="cidade">Cidade:</label>
                    <input name="cidade" type="text" class="form-control" id="cidade" size="40" value="@if(old('cidade')){{ old('cidade') }}@endif" placeholder="Cidade" />
                    @if($errors->has('cidade'))
                    <span class="help-block">@foreach($errors->get('cidade') as $error){{ $error }}@endforeach</span>
                    @endif
                </div>
                <div class="@if($errors->has('uf')) has-error @endif col-md-3 col-md-offset-0">
                    <label for="uf">Estado:</label>
                    <input name="uf" type="text" class="form-control" id="uf" size="2" value="@if(old('uf')){{ old('uf') }}@endif" placeholder="uf" />
                    @if($errors->has('uf'))
                    <span class="help-block">@foreach($errors->get('uf') as $error){{ $error }}@endforeach</span>
                    @endif
                </div>
                <div class="@if($errors->has('num')) has-error @endif col-md-3 col-md-offset-0">
                    <label for="num">Nº:</label>
                    <input name="num" type="text" class="form-control" id="num" value="@if(old('num')){{ old('num') }}@endif" placeholder="Nº" />
                    @if($errors->has('num'))
                    <span class="help-block">@foreach($errors->get('num') as $error){{ $error }}@endforeach</span>
                    @endif
                </div>
                <div class="@if($errors->has('etc')) has-error @endif col-md-3 col-md-offset-0">
                    <label for="etc">Complemento</label>
                    <input type="text" name="etc" id="etc" class="form-control" value="@if(old('etc')){{ old('etc') }}@endif" placeholder="Complemento" />
                    @if($errors->has('etc'))
                    <span class="help-block">{{ $errors->first('etc') }}</span>
                    @endif
                </div>
                <div class="col-md-3 col-md-offset-0">
                    @if(Auth::check())
                    <label for="owner">Tec. responsável: {{ Auth::user()->name }}</label>
                    @else
                    <label for="owner">&nbsp</label>
                    @endif
                    <input type="hidden" name="owner" class="form-control" value="@if(old('owner')){{ old('owner') }}@endif" placeholder="Tec. responsável" />
                    <ul class="actions">
                        <li><a href="/users" class="button special small">Cancelar</a></li>
                        <li><button type="submit" class="button success small">Salvar</button></li>
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