@extends('layouts.default')

@section('title' , 'Usuários')

@push('styles')
@endpush


@section('content')
<header class="major">
    <h2>Usuários do sistema</h2>
    <p>Essa é a página de gerenciamento. Aqui voce pode visualizar, selecionar cadastrar ou deletar usuários</p>
</header>
<section>
    <div class="table-wrapper">Usuários de {{ auth()->user()->name }}:</div>
    <table class="alt">
        <thead>
            <tr>
                <th>id</th>
                <th>usuário</th>
                <th class="d-none d-lg-table-cell ">telefone</th>
                <th class="d-none d-lg-table-cell ">email</th>
                <th class="d-none d-lg-table-cell ">product</th>
                <th class="d-none d-lg-table-cell ">team</th>
                <th class="d-none d-lg-table-cell ">expires_at</th>
                <th class="text-right">
                    <a href="/user/create" class="icon solid fa-plus special"></a>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            @if(auth()->user()->id == '1' || $user->teams->first()->id == auth()->user()->id)
            <tr>
                <th><a class="clean" href="/user/{{ $user->id; }}/show">{{ $user->id; }}</a></th>
                <th><a class="clean" href="/user/{{ $user->id; }}/show">{{ $user->name; }}</a></th>
                <th class="d-none d-lg-table-cell"><a target="_new" href="https://wa.me/55{{ $user->phone; }}" class="icon clean alt fa-whatsapp"><span class="label">Whatsapp</span></a> {{ $user->phone; }}</th>
                <th class="d-none d-lg-table-cell"><a href="mailto:{{ $user->email; }}" class="icon alt fa-envelope"><span class="label">Email</span></a> {{ $user->email; }}</th>
                <th class="d-none d-lg-table-cell">
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
                    $date = new DateTime($user->contracts->last()->created_at);
                    $date->add(new DateInterval('P1M'));
                    echo $date->format('d/m/Y H:i:s');
                    @endphp
                    @endif
                </th>
                <th class="text-right">
                    <a href="/user/{{ $user->id; }}/edit" class="icon solid fa-edit"></a>
                    <a href="/user/{{ $user->id; }}/delete" class="icon solid fa-trash"></a>
                </th>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
    </div>
</section>
@endsection