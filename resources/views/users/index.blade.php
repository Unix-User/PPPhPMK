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
    <div class="table-wrapper">Usuários: <br />
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
                <tr>
                    <th><a class="clean" href="/user/{{ $user->id; }}/show">{{ $user->id; }}</a></th>
                    <th><a class="clean" href="/user/{{ $user->id; }}/show">{{ $user->name; }}</a></th>
                    <th class="d-none d-lg-table-cell"><a target="_new" href="https://wa.me/55{{ $user->phone; }}" class="icon clean alt fa-whatsapp"><span class="label">Whatsapp</span></a> {{ $user->phone; }}</th>
                    <th class="d-none d-lg-table-cell"><a href="mailto:{{ $user->email; }}" class="icon alt fa-envelope"><span class="label">Email</span></a> {{ $user->email; }}</th>
                    <th class="d-none d-lg-table-cell">
                        @foreach($user->contracts as $contract)
                        {{ $contract->name }}<br />
                        @endforeach
                    </th>
                    <!-- display all teams this user belongs to -->
                    <th class="d-none d-lg-table-cell">
                        @foreach($user->teams as $team)
                        {{ $team->name; }}
                        @endforeach
                    </th>
                    <th class="d-none d-lg-table-cell">
                        {{ ($user->expires_at == null || $user->expires_at == '0000-00-00') ? 'N/A' : date('d-m-Y', strtotime($user->expires_at)); }}
                    </th>
                    <th class="text-right">
                        <a href="/user/{{ $user->id; }}/edit" class="icon solid fa-edit"></a>
                        <a href="/user/{{ $user->id; }}/delete" class="icon solid fa-trash"></a>
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