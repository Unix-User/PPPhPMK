@extends('layouts.default')

@section('title' , 'Usuários')

@push('styles')
<link rel="stylesheet" href=" {{ mix('css/style.css')}} " />
@endpush


@section('content')
<header class="major">
    <h2>Usuários do sistema</h2>
    <p>Essa é a página de gerenciamento. Aqui voce pode visualizar, selecionar cadastrar ou deletar usuários</p>
</header>
<section>
    <div class="table-wrapper">Usuários: <br />
        <table class="alt">
            <thead>
                <tr>
                    <th>id</th>
                    <th>usuário</th>
                    <th>telefone</th>
                    <th class="hidden-xs">email</th>
                    <th class="hidden-xs">product</th>
                    <th class="hidden-xs">team</th>
                    <th class="hidden-xs">expires_at</th>
                    <th class="text-right">
                        <a href="/user/create" class="icon fa-plus special"></a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <th><a class="clean" href="/user/{{ $user->id; }}/show">{{ $user->id; }}</a></th>
                    <th><a class="clean" href="/user/{{ $user->id; }}/show">{{ $user->name; }}</a></th>
                    <th class="clean"><a target="_new" href="https://wa.me/55{{ $user->phone; }}" class="icon alt fa-whatsapp"><span class="label">Whatsapp</span></a> {{ $user->phone; }}</th>
                    <th class="hidden-xs"><a href="mailto:{{ $user->email; }}" class="icon alt fa-envelope"><span class="label">Email</span></a> {{ $user->email; }}</th>
                    <th class="hidden-xs">
                        @foreach($user->contracts as $contract)
                        {{ $contract->name }}<br />
                        @endforeach
                    </th>
                    <!-- display all teams this user belongs to -->
                    <th class="hidden-xs">
                        @foreach($user->teams as $team)
                        {{ $team->name; }}
                        @endforeach
                    </th>
                    <th class="hidden-xs">
                        {{ ($user->expires_at == null || $user->expires_at == '0000-00-00') ? 'N/A' : date('d-m-Y', strtotime($user->expires_at)); }}
                    </th>
                    <th class="text-right">
                        <a href="/user/{{ $user->id; }}/edit" class="icon fa-edit"></a>
                        <a href="/user/{{ $user->id; }}/delete" class="icon fa-trash"></a>
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