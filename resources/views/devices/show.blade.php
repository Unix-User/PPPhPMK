@extends('layouts.default')

@section('title' , 'Dispositivos')

@push('styles')

@endpush


@section('content')
<header class="major">
    <h2>{{ $device->name }}</h2>
    <p>Nessa página estão todos os usuários conectados e registrados em {{ $device->name }}</p>
</header>
<section>
    <div class="table-wrapper" id="connected">
        <table class="alt">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Perfil</th>
                    <th>Tempo conectado</th>
                    <th>Endereço IP</th>
                    <th>Endereço MAC</th>
                    <th class="text-right"><a href="/device/{{ $device->id }}/sync" class="icon solid fa-sync" data-toggle="tooltip" title="Sincronizar com {{ $device->name }}"></a></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($newUsers as $active)
                <tr>
                    <th><a class="clean" href="/user/{{ $active->id }}/show">{{ $active->name }}</a></th>
                    <th>{{ (isset($active->profile)) ? (($active->contracts->last()->product->tags == null) ? 'default' : $active->contracts->last()->product->tags . "m" ) : "Não registrado" ; }}</th>
                    <th>{{ $active->uptime }}</th>
                    <th><a href="http://{{ $active->address }}" target="_blank" class="icon solid fa-link" data-toggle="tooltip" title="Acessar antena/roteador"> {{ $active->address }}</a></th>
                    <th>{{ $active->mac }}</th>
                    <th class="text-right">
                        @if ($active->status == "false")
                        <a href="/user/{{ $active->name }}/disable" class="icon solid fa-unlock" data-toggle="tooltip" title="Bloquear usuário"></a>
                        @else
                        <a href="/user/{{ $active->name }}/enable" class="icon solid fa-lock" data-toggle="tooltip" title="Desbloquear usuário"></a>
                        @endif
                        <a href="/user/{{ $active->name }}/disconnect" class="icon solid fa-wifi" data-toggle="tooltip" title="Desconectar usuário de {{ $device->name }}"></a>
                        <a href="/user/{{ $active->name }}/remove" class="icon solid fa-trash" data-toggle="tooltip" title="Remover usuário de {{ $device->name }}"></a>
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection