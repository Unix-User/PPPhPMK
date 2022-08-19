@extends('layouts.default')

@section('title' , 'Usuários')

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
    <h2>Usuários do sistema</h2>
    <p>Essa é a página de gerenciamento. Aqui voce pode visualizar, selecionar cadastrar ou deletar usuários</p>
</header>
<section>
    <div class="table-wrapper">Usuários de {{ auth()->user()->name }}:</div>
    <table class="alt">
        <thead>
            <tr>
                <th>usuário</th>
                <th class="d-none d-lg-table-cell ">telefone</th>
                <th class="d-none d-lg-table-cell ">email</th>
                <th class="d-none d-lg-table-cell ">produto</th>
                <th class="d-none d-lg-table-cell ">time</th>
                <th class="d-none d-lg-table-cell ">expiração</th>
                <th class="text-right">
                    <a href="/user/create" class="icon solid fa-plus special"></a>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)

            <tr>
                <th>
                    @php
                    $d1 = strtotime($user->contracts->last()->updated_at);
                    $d2 = ceil(($d1 - time()) / 60 / 60 / 24);
                    @endphp
                    @if ($d2 + 30 < 1) <a class="clean text-warning" href="/user/{{ $user->id; }}/show">{{ $user->id; }} - {{ $user->name; }}</a>
                        @else
                        <a class="clean" href="/user/{{ $user->id; }}/show">{{ $user->id; }} - {{ $user->name; }}</a>
                        @endif
                </th>
                <th class="d-none d-lg-table-cell"><a target="_new" href="https://wa.me/55{{ $user->phone; }}" class="icon clean alt fa-whatsapp"><span class="label">Whatsapp</span></a> {{ $user->phone; }}</th>
                <th class="d-none d-lg-table-cell"><a href="mailto:{{ $user->email; }}" class="icon alt fa-envelope"><span class="label">Email</span></a> {{ $user->email; }}</th>
                @php
                $d1 = strtotime($user->contracts->last()->updated_at);
                $d2 = ceil(($d1 - time()) / 60 / 60 / 24);
                @endphp

                @if ($d2 + 30 < 1) <th class="text-warning d-none d-lg-table-cell">
                    @else
                    <th class="d-none d-lg-table-cell">
                        @endif
                        @if($user->contracts->last())
                        {{ $user->contracts->last()->product->id; }} -
                        {{ $user->contracts->last()->product->name; }}
                        @endif
                    </th>

                    <th class="d-none d-lg-table-cell">
                        @if($user->teams->first())
                        {{ $user->teams->first()->id; }} -
                        {{ $user->teams->first()->name; }}
                        @endif
                    </th>
                    <th class="d-none d-lg-table-cell">
                        @if($user->contracts->last())
                        @php
                        $date = new DateTime($user->contracts->last()->updated_at);
                        $date->add(new DateInterval('P30D'));
                        echo $date->format('d/m/Y H:i:s');
                        @endphp
                        @endif
                    </th>
                    <th class="text-right">
                        @if(auth()->user()->id == '1' || $user->teams->first()->name == auth()->user()->name)
                        <a href="/user/{{ $user->id; }}/edit" class="icon solid fa-edit"></a>
                        <a href="/user/{{ $user->id; }}/delete" class="icon solid fa-trash"></a>
                        @else
                        <a href="#" class="icon solid fa-edit" onclick="alert('Não é possivel editar esse usuário')"></a>
                        <a href="#" class="icon solid fa-trash" onclick="alert('Não é possivel remover esse usuário')"></a>
                        @endif
                    </th>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
    </div>
</section>
@endsection