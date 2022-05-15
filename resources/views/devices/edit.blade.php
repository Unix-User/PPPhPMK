@extends('layouts.default')

@section('title' , 'Dispositivos')

@push('styles')
<link rel="stylesheet" href=" {{ mix('css/style.css')}} " />
@endpush


@section('content')
<div class="container">
    <header class="major">
        <h2>Editar Dispositivo</h2>
        <p>Aqui voce pode editar um dispositivo existente para usar com o sistema</p>
    </header>
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-custom">
                <div class="card-body">
                    <form action="/device/{{ $device->id }}/update/" method="POST">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="name">Dispositivo</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $device->name }}">
                            @if ($errors->has('name'))
                            <span class="help-block">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="ip">IP Address</label>
                            <input type="text" class="form-control" id="ip" name="ip" placeholder="IP Address" value="{{ $device->ip }}">
                            @if($errors->has('ip'))
                            <span class="help-block">{{ $errors->first('ip') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="user">Usuario</label>
                            <input type="text" class="form-control" id="user" name="user" placeholder="User" value="{{ $device->user }}">
                            @if($errors->has('user'))
                            <span class="help-block">{{ $errors->first('user') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="text" class="form-control" id="password" name="password" placeholder="Password" value="{{ $device->password }}">
                            @if($errors->has('password'))
                            <span class="help-block">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="ikev2" id="ikev2" value="1" {{ $device->ikev2 ? 'checked' : '' }}>
                            <label for="ikev2">IKEv2</label>
                        </div>
                        <a href="/devices" class="clean">
                            <button type="button" class="btn btn-danger">
                                <i class="fa fa-times"></i> Cancelar
                            </button>
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-check"></i> Salvar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

@endpush