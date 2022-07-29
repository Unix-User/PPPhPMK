@extends('layouts.default')

@section('title' , 'Dispositivos')

@push('styles')

@endpush


@section('content')
<header class="major">
    <h2>Dispositivos</h2>
    <p>Aqui voce obtem informções detalhadas dos dispositivos conectados ao servidor</p>
</header>
<div>
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
    <div class="panel-body row 50% uniform">
        <a href="/device/create" class="icon fa-plus special pull-right"></a>
    </div>&nbsp
    <div class="card-columns">
        @foreach ($detailed as $device)
        <div class="col">
            <div class="card bg-custom h-100">
                <div class="card-body">
                    <a href="/device/{{ $device['id'] }}">
                        <h3 class="h3"><i class="bi-router"></i> {{ $device['name'] }}</h3>
                        <small class="text-muted float-right">CPU: {{ $device['cpu_load'] }}%</small>
                    </a>
                    <p class="card-text text-justify">IP: {{ $device['ip'] }}
                        <br />Tempo ligado: {{ $device['uptime'] }}
                        <br />Dispositivo: {{ $device['board_name'] }}
                        <br />Version: {{ $device['version'] }}
                    </p>
                </div>
                <div class="card-footer float-right">
                    <small class="text-muted">
                        <a class="clean icon fa-key" href="/device/{{ $device['id'] }}/connect"></a>
                        <a class="clean icon fa-sync" href="/device/{{ $device['id'] }}/sync"></a>
                        <a href="/device/{{ $device['id'] }}/edit" class="clean icon fa-edit"></a>
                        <a href="/device/{{ $device['id'] }}/delete" onclick="return confirm('Deseja remover esse dispositivo?')" class="clean icon fa-trash"></a>
                    </small>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<div class="d-flex justify-content-center">
    {{ $detailed->links() }}
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