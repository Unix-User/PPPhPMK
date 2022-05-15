<!DOCTYPE html>
<html>

<head>
    <title><a href="https://unixlocal.ml">Unix.Local</a></title>
</head>

<body>
    <h1>Recuperação de senha</h1>
    <p>{{ __('Olá') }} {{ $user->name }},</p>

    <p>{{ __('Foi solicitado uma recuperação de senha para sua conta.') }}</p>
    <p>{{ __('Para recuperar sua senha, clique no link abaixo ou copie e cole no seu navegador:') }}</p>
    
    <p>
        <a href="{{ route('renew', $token) }}">
            {{ route('renew', $token) }}
        </a>
    </p>

</body>

</html>