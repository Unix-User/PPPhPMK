@extends('layouts.default')

@section('title' , '{{ $product->name }}')

@push('styles')
@endpush

@section('content')
<header class="major">
    <h2>{{ $product->name }}</h2>
    <p>Confira os detalhes do plano {{ $product->name }}</p>
</header>
<div class="card-deck">
    <div class="card col-sm-4 bg-custom">
        <a class="clean" href="/product/{{  $product->id; }}/show">
            <div class="card-header">
                <span class="icon alt fa-wifi"></span>
                <strong class="text-capitalize"> {{ $product->name }}</strong>
            </div>
            <img class="card-img-top" src="/images/{{ $product->image }}" alt="Card image">
            <div class="card-footer">
                <ul class="actions">
                    <li>
                        <a href="/product/{{ $product->id }}/select" class="button" onclick="return confirm('Tem certeza que deseja mudar o seu plano? Ao confirmar seu usuário será designado para o time tecnico especifcado no plano selecionado e um novo contrato será gerado para o seu plano. A ativação será processada ao finalizar o pagamento!')">Selecionar</a>
                    </li>
                </ul>
            </div>
        </a>
    </div>
    <div class="card col-sm-8 bg-custom">
        <div class="card-header">
            <span class="icon alt fa-info-circle"></span>
            <span class="text-capitalize"><strong> Detalhes do produto</strong></span>
            </span>
        </div>
        <div class="card-body">
            <div class="row">
                <p class="card-text">{{ $product->description }}</p>

                </p>
            </div>
        </div>
        <div class="card-footer">
            <ul class="actions">
                <li class="float-right align-bottom">
                    <h1 class="h1 text-right">R${{ $product->price }}</h1>
                    <small class="float-right text-muted">Resp. técnico: {{ $product->user->name }}</small>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection