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
    <h2>Sistema</h2>
    <p>Aqui voce pode editar e aplicar configurações ou visualizar logs.</p>
</header>
<section>
    <div class="card-deck">
        <div class="card bg-custom">
            <div class="card-header">
                <span class="icon alt fa-money-bill-alt"></span>
                <strong class="text-capitalize"> Mercado pago</strong>
            </div>
            <div class="card-body">
                <form action="/system/{{auth()->user()->id}}/config" method="POST">
                    @csrf
                    <label class="form-label" for="password">
                        Senha de instalação do servidor pppoe
                    </label>
                    <input id="password" type="password" name="password" value="{{ $teams->where('name', auth()->user()->name)->first()->password }}" onchange="this.form.submit()" class="form-control">
                    <label>Configurações da API do mercado pago:</label>
                    <div class="form-group form-check-inline">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="mercado_pago" id="mercado_pago_produção" value="prod" onchange="this.form.submit()" {{ ($teams->where('name', auth()->user()->name)->first()->mode == 'prod') ? 'checked' : '' }}>
                            <label class="form-check-label" for="mercado_pago_produção">
                                Produção
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="mercado_pago" id="mercado_pago_teste" value="dev" onchange="this.form.submit()" {{ ($teams->where('name', auth()->user()->name)->first()->mode == 'dev') ? 'checked' : '' }}>
                            <label class="form-check-label" for="mercado_pago_teste">
                                Testes
                            </label>
                        </div>
                    </div>
                    <label>Chave publica da API mercado pago:</label>
                    <input id="key" type="text" name="key" value="{{ $teams->where('name', auth()->user()->name)->first()->key }}" onchange="this.form.submit()" class="form-control">
                    <label>Chave publica de testes da API mercado pago:</label>
                    <input id="test_key" type="text" name="test_key" value="{{ $teams->where('name', auth()->user()->name)->first()->test_key }}" onchange="this.form.submit()" class="form-control">
                    <label>Token de acesso da API mercado pago:</label>
                    <input id="token" type="text" name="token" value="{{ $teams->where('name', auth()->user()->name)->first()->token }}" onchange="this.form.submit()" class="form-control">
                    <label>Token de acesso de testes da API mercado pago:</label>
                    <input id="test_token" type="text" name="test_token" value="{{ $teams->where('name', auth()->user()->name)->first()->test_token }}" onchange="this.form.submit()" class="form-control">
                </form>
                Logs do Mercado Pago: <br />
                <pre style="overflow-x: hidden; height: 100px; color: #FFF;"><code>{{ $log }}</code></pre>
                <table class="alt small">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th class="d-none d-lg-table-cell ">reference</th>
                            <th class="d-none d-lg-table-cell ">Data</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contracts as $contract)
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
    </div>
</section>
@endsection