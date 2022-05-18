@extends('layouts.default')

@section('title' , '{{ $user->name }}')

@push('styles')
<link rel="stylesheet" href=" {{ mix('css/style.css')}} " />
@endpush

@section('content')

@if(session()->has('success'))
<div class="alert alert-success" style="width: 100%; position: relative; background-color: #272833; border-color: #155724" role="alert">
    {{ session()->get('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if(session()->has('error'))
<div class="alert alert-danger" style="width: 100%; position: relative; background-color: #272833; border-color: #843534" role="alert">
    {{ session()->get('error') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<header class="major">
    <h2>Bem vindo <span class="text-capitalize">{{ $user->name }}</span>!</h2>
    <p>Use essa página para obter informações sobre seu usuário e serviços contratados</p>
</header>
<!-- Content -->
<div class="card-deck">
    <div class="card col-sm-4 bg-custom">
        <a class="clean" href="/product/{{  $user->contracts->first()->id; }}/show">
            <div class="card-header">
                <span class="icon alt fa-wifi"></span>
                <strong class="text-capitalize">{{ $user->contracts->first()->name }}</strong>
            </div>
            <img class="card-img-top" src="/images/{{ $user->contracts->first()->image }}" alt="Card image cap">
            <div class="card-body">
                <p class="card-text">{{ $user->contracts->first()->description; }}
                    <br />Técnico: <a href="/user/{{ $user->contracts->first()->user->id }}/show">{{ $user->contracts->first()->user->name }}</a>
                </p>
                <p class="card-text"><small class="text-muted"> R${{ $user->contracts->first()->price; }}</small></p>
            </div>
            <div class="card-footer">
                <ul class="actions">
                    <li><a href="/products" class="button">Selecionar outro plano</a></li>
                </ul>
            </div>
        </a>
    </div>
    <div class="card col-sm-8 bg-custom">
        <div class="card-header">
            <span class="icon alt fa-user"></span>
            <strong class="text-capitalize">{{ $user->name }}</strong>
        </div>
        <div class="card-body">

            <p class="card-text">
            <form action="/processar_pagamento" method="POST">
                <ul>
                    <li><strong>Email: </strong>{{ $user->email }}</li>
                    <li><strong>Telefone: </strong>{{ $user->phone }}</li>
                    <li><strong>CEP: </strong>{{ $user->cep }}</li>
                    <li><strong>Rua: </strong>{{ $user->rua }}</li>
                    <li><strong>Bairro: </strong>{{ $user->bairro }}</li>
                    <li><strong>Cidade: </strong>{{ $user->cidade }}</li>
                    <li><strong>Estado: </strong>{{ $user->uf }}</li>
                    <li><strong>Nº: </strong>{{ $user->num }}</li>
                    <li><strong>Complemento: </strong>{{ $user->complemento }}</li>
                </ul>
            </form>
            </p>
        </div>
        <div class="card-footer">
            <ul class="actions">
                <li><a href="/user/{{ $user->id }}/payment" class="button">Pagar</a></li>
                <li><a href="/user/{{ $user->id }}/edit" class="button">Editar</a></li>
            </ul>
        </div>
    </div>
</div>
<hr />
<div class="card-deck">
    <div class="card col-sm-4 bg-custom">
        <div class="card-header">
            <span class="icon alt fa-history"></span>
            <strong class="text-capitalize"> Registros de atividade</strong>
        </div>
        <div class="card-body">
            <p class="card-text">Os dados podem demorar até 10 minutos para serem atualizados com o servidor.</p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item bg-custom">Ultimos registros</li>
        </ul>
    </div>
    <div class="card col-sm-8 bg-custom">
        <div class="card-header">
            <span class="icon alt fa-chart-bar"></span>
            <strong class="text-capitalize"> Graficos de consumo</strong>
        </div>
        <div class="card-body">
            <div id="linhas" style="width: 100%; height: auto;"></div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
    $(function() {
        $('#nav-profile-tab').tab('show')
    })

    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).val()).select();
        document.execCommand("copy");
        $temp.remove();
    }
</script>
@endpush

@prepend('scripts')
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
@endprepend