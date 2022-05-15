@extends('layouts.default')

@section('title' , 'Dispositivos')

@push('styles')
<link rel="stylesheet" href=" {{ mix('css/style.css')}} " />
@endpush


@section('content')
<header class="major">
    <h2>Dispositivos</h2>
    <p>Aqui voce obtem informções detalhadas dos dispositivos conectados ao servidor</p>
</header>
<div>
    <!-- if any alert messages -->
    @if(session()->has('success'))
    <div class="alert alert-success" style="width: 100%; position: relative; background-color: #272833; border-color: #155724" role="alert">
        {{ session()->get('success') }}
        <!-- close alert button -->
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if(session()->has('error'))
    <div class="alert alert-danger" style="width: 100%; position: relative; background-color: #272833; border-color: #843534" role="alert">
        {{ session()->get('error') }}
        <!-- close alert button -->
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="panel-body row 50% uniform">
        <a href="/device/create" class="icon fa-plus special pull-right"></a>
    </div>&nbsp
    <div class="card-columns">
        @foreach ($devices as $device)
        <div class="col">
            <div class="card bg-custom h-100">
                <div class="card-body">
                    <a href="/device/{{ $device->id }}">
                        <h3 class="h3"><i class="bi-router"></i> {{ $device->name }}</h3>
                    </a>
                    <p class="card-text text-justify">Endereço IP: {{ $device->ip }}</p>
                    <p>
                        <br />Tempo ligado: sistema desconectado
                        <br />Clientes cadastrados: --
                        <br />Clientes conectados: --
                    </p>
                </div>
                <div class="card-footer">
                    <small class="text-muted float-end">

                        <button class="btn btn-primary btn-xs" type="button" onclick="location.reload()">
                            <i class="icon fa-sync"></i>
                        </button>

                        <a class="clean" href="/device/{{ $device->id }}/getCert" onclick="alert('Baixando seu certificado')">
                            <button class="btn btn-success btn-xs" type="button">
                                <i class="icon fa-download"></i>
                            </button>
                        </a>

                        <a class="clean" href="/device/{{ $device->id }}/edit">
                            <button class="btn btn-warning btn-xs" type="button">
                                <i class="icon fa-edit"></i>
                            </button>
                        </a>
                        <a class="clean" href="/device/{{ $device->id }}/delete">
                            <button class="btn btn-danger btn-xs" type="button" onclick="return confirm('Deseja remover esse dispositivo?')">
                                <i class="icon fa-trash"></i>
                            </button>
                        </a>
                    </small>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script src="/assets/js/fetch.js"></script>
<script>
    document.getElementsByClassName("sync").addEventListener("click", function() {
        alert('sincronizando');
    });
</script>
@endpush