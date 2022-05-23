@extends('layouts.default')

@section('title' , '{{ $user->name }}')

@push('styles')
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
    @if($user->contracts->count() > 0)
    <div class="card col-sm-4 bg-custom">
        <a class="clean" href="/product/{{  $user->contracts->first()->id; }}/show">
            <div class="card-header">
                <span class="icon alt fa-wifi"></span>
                <strong class="text-capitalize">{{ $user->contracts->first()->name }}</strong>
            </div>
            <img class="card-img-top" src="/images/{{ $user->contracts->first()->image }}" alt="Card image cap">
            <div class="card-body">
                <p class="card-text text-truncate">{{ $user->contracts->first()->description; }}
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
    @else
    <div class="card col-sm-4 bg-custom">
        <a class="clean" href="/products">
            <div class="card-header">
                <span class="icon alt fa-wifi"></span>
                <strong class="text-capitalize">Selecione um Plano</strong>
            </div>
            <img class="card-img-top" src="/images/pic01.jpg" alt="Card image cap">
            <div class="card-body">
                <p class="card-text text-truncate">Selecione um plano para continuar
                </p>
                <p class="card-text"><small class="text-muted"> R$ -- </small></p>
            </div>
            <div class="card-footer">
                <ul class="actions">
                    <li><a href="/products" class="button">Selecionar outro plano</a></li>
                </ul>
            </div>
        </a>
    </div>
    @endif
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
                @if($user->contracts->count() > 0)
                <li><a href="/user/{{ $user->id }}/payment" class="button">Pagar</a></li>
                @endif
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
