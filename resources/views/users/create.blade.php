@extends('layouts.default')

@section('title' , 'Criar usuário')

@push('styles')
<link rel="stylesheet" href=" {{ mix('css/style.css')}} " />
<!-- Adicionando JQuery    -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endpush


@section('content')
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
<div class="row">
    <div class="col-xs-12 col-xs-offset-0">
        <div>
            <div class="panel-heading">
                <h3 class="panel-title">Criar usuário</h3>
            </div>
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
                        <div class=" @if($errors->has('phone')) has-error @endif col-md-3 col-md-offset-0">
                            <label for="title">Telefone</label>
                            <input type="text" name="phone" class="form-control" value="@if(old('phone')){{ old('phone') }}@endif" placeholder="Telefone" />
                            @if($errors->has('phone'))
                            <span class="help-block">@foreach($errors->get('phone') as $error){{ $error }}@endforeach</span>
                            @endif
                        </div>
                        <div class=" @if($errors->has('password')) has-error @endif col-md-3 col-md-offset-0">
                            <label for="title">Senha</label>
                            <input type="password" name="password" class="form-control" value="@if(old('password')){{ old('password') }}@endif" placeholder="Senha" />
                            @if($errors->has('password'))
                            <span class="help-block">@foreach($errors->get('password') as $error){{ $error }}@endforeach</span>
                            @endif
                        </div>
                        <div class=" @if($errors->has('category_id')) has-error @endif col-md-3 col-md-offset-0">
                            <label for="category_id">Plano</label>
                            <div class="select-wrapper">
                                <select name="category_id[]" class="form-control" placeholder="Selecione um plano">
                                    @foreach($products as $product)
                                    <option value="{{ $product->id }}" @if(old('category_id')==$product->id) selected @endif>{{ $product->name }}</option>
                                    @endforeach
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
                        <div class=" @if($errors->has('cep')) has-error @endif col-md-3 col-md-offset-0">
                            <label for="cep">Cep:</label>
                            <input name="cep" type="text" id="cep" class="form-control" size="10" maxlength="9" onblur="pesquisacep(this.value);" value="@if(old('cep')){{ old('cep') }}@endif" placeholder="Cep" />
                            @if($errors->has('cep'))
                            <span class="help-block">@foreach($errors->get('cep') as $error){{ $error }}@endforeach</span>
                            @endif
                        </div>
                        <div class=" col-md-3 col-md-offset-0">
                            <label for="rua">Rua:</label>
                            <input name="rua" type="text" class="form-control" id="rua" size="60" value="@if(old('rua')){{ old('rua') }}@endif" placeholder="Rua" />
                        </div>
                        <div class=" col-md-3 col-md-offset-0">
                            <label>Bairro:</label>
                            <input name="bairro" type="text" class="form-control" id="bairro" size="40" value="@if(old('bairro')){{ old('bairro') }}@endif" placeholder="Bairro" />
                        </div>
                        <div class=" col-md-3 col-md-offset-0">
                            <label for="cidade">Cidade:</label>
                            <input name="cidade" type="text" class="form-control" id="cidade" size="40" value="@if(old('cidade')){{ old('cidade') }}@endif" placeholder="Cidade" />
                        </div>
                        <div class=" col-md-3 col-md-offset-0">
                            <label for="estado">Estado:</label>
                            <input name="uf" type="text" class="form-control" id="uf" size="2" value="@if(old('uf')){{ old('uf') }}@endif" placeholder="Estado" />
                        </div>
                        <div class=" col-md-3 col-md-offset-0">
                            <label for="num">Nº:</label>
                            <input name="num" type="text" class="form-control" id="num" value="@if(old('num')){{ old('num') }}@endif" placeholder="Nº" />
                        </div>
                        <!-- div for teams -->
                        <div class="col-md-3 col-md-offset-0">
                            <label for="title">Equipe</label>
                            <div class="select-wrapper">
                                <select name="team_id[]" class="form-control" multiple="multiple" placeholder="Selecione uma equipe">
                                    @foreach($teams as $team)
                                    <option value="{{ $team->id }}" @if(old('team_id')==$team->id) selected @endif>{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class=" col-md-3 col-md-offset-0">
                            <label for="owner">Tec. responsável:</label>
                            <input type="hidden" name="owner" class="form-control" value="@if(old('owner')){{ old('owner') }}@endif" placeholder="Tec. responsável" />
                            <ul class="actions">
                                <li><a href="/users" class="button special small">Cancelar</a></li>
                                <li><button type="submit" class="button success small">Salvar</button></li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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