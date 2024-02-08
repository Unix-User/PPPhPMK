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
        <a class="clean" href="/product/{{  $user->contracts->last()->product->id }}/show">
            <div class="card-header">
                <span class="icon alt fa-wifi"></span>
                <strong class="text-capitalize">{{ $user->contracts->last()->product->name }}</strong>
            </div>
            <img class="card-img-top" src="/images/{{ $user->contracts->last()->product->image }}" alt="Card image cap">
            <div class="card-body">
                <p class="card-text text-truncate">{{ $user->contracts->last()->product->description }}</p>
                <small class="float-left text-muted">Resp. técnico: {{ $user->contracts->last()->product->user->name }}</small>
            </div>
            <div class="card-footer">
                <ul class="actions">
                    <li><a href="/products" class="button">
                            @if (Auth::user()->teams->first()->id != '1')
                            Selecionar outro plano
                            @else()
                            Gerenciar planos para venda
                            @endif</a></li>
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
            <strong class="text-capitalize">Dados do cliente</strong>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-3 col-md-offset-0">
                    <input type="text" class="form-control-sm" value="{{ $user->name }}" readonly />
                    <label class="text-muted">Usuário: </label>
                </div>
                <div class="col-md-5 col-md-offset-0">
                    <input type="text" class="form-control-sm" value="{{ $user->email }}" readonly />
                    <label class="text-muted">Email: </label>
                </div>
                <div class="col-md-4 col-md-offset-0">
                    <input type="text" class="form-control-sm" value="{{ $user->phone }}" readonly />
                    <label class="text-muted">Telefone: </label>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3 col-md-offset-0">
                    <input type="text" class="form-control-sm" value="{{ $user->cep }}" readonly />
                    <label class="text-muted">CEP: </label>
                </div>
                <div class="col-md-4 col-md-offset-0">
                    <input type="text" class="form-control-sm" value="{{ $user->bairro }}" readonly />
                    <label class="text-muted">Bairro: </label>
                </div>
                <div class="col-md-3 col-md-offset-0">
                    <input type="text" class="form-control-sm" value="{{ $user->cidade }}" readonly />
                    <label class="text-muted">Cidade: </label>
                </div>
                <div class="col-md-2 col-md-offset-0">
                    <input type="text" class="form-control-sm" value="{{ $user->uf }}" readonly />
                    <label class="text-muted">Estado: </label>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-7 col-md-offset-0">
                    <input type="text" class="form-control-sm" value="{{ $user->rua }}" readonly />
                    <label class="text-muted">Rua: </label>
                </div>
                <div class="col-md-2 col-md-offset-0">
                    <input type="text" class="form-control-sm" value="{{ $user->num }}" readonly />
                    <label class="text-muted">Nº: </label>
                </div>
                <div class="col-md-3 col-md-offset-0">
                    <input type="text" class="form-control-sm" value="{{ $user->complemento }}" readonly />
                    <label class="text-muted">Complemento: </label>
                </div>
            </div>
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
    <div class="card bg-custom">
        <div class="card-header">
            <span class="icon alt fa-history"></span>
            <strong class="text-capitalize"> Histórico de contratações</strong>
        </div>
        <table class="card-body alt small">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th class="d-none d-lg-table-cell ">Referencia</th>
                    <th class="d-none d-lg-table-cell ">Contratação</th>
                    <th>Habilitação</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user->contracts as $contract)
                <tr>
                    <td class="text-truncate">{{ isset($contract->product) ? $contract->product->name : 'null' ; }}</td>
                    <td class="d-none d-lg-table-cell ">{{ $contract->reference }}</td>
                    <td class="d-none d-lg-table-cell ">{{ $contract->created_at }}</td>
                    <td class="text-nowrap">{{ $contract->updated_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- future fearures
<hr />
<div class="card-deck">
<div class="card col-sm-8 bg-custom">
        <div class="card-header">
            <span class="icon alt fa-chart-bar"></span>
            <strong class="text-capitalize"> Graficos de consumo</strong>
        </div>
        <div class="card-body">
            <div id="linhas" style="width: 100%; height: auto;"></div>
        </div>
    </div>
</div> -->
@endsection