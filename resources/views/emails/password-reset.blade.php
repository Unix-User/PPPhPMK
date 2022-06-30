<!DOCTYPE html>
<html>

<head>
    <title>Recuperação de senha</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="css/style.css" />
    <noscript>
        <link rel="stylesheet" href="css/noscript.css" />
    </noscript>
</head>

<body>
    <header id="header">
        <nav id="nav">
            <ul>
                <li>
                    <h1 id="logo"><a href="https://unixlocal.tk">Unix.Local</a></h1>
                </li>
                <li><a href="https://unixlocal.tk/products">Produtos</a></li>
            </ul>
        </nav>
    </header>
    <div id="main" class="wrapper style1">
        <div class="container">
            <div class="card justify-content-center">
                <div class="card-header">
                    <header class="major">
                        <h2>Deseja recuperar sua senha?</h2>
                        <p>Siga o procedimento abaixo para recuperar o acesso a sua conta</p>
                    </header>
                </div>
                <div class="card-body">
                    <p>{{ __('Oi') }} {{ $user->name }},<br />
                        Um procedimento para recuperar sua senha de acesso foi solicitado em {{ date('d/m/Y H:i:s') }}<br />
                        Para recuperar o acesso a sua conta e alterar a senha clique em "recuperar senha" logo abaixo:<br />
                    </p>
                    <a class="button special" href="{{ route('renew', $token) }}">
                        Recuperar senha
                    </a>
                    <br />
                    {{ __('ou copie e cole o link no seu navegador:') }}<br />
                    <a class="text-muted small" href="{{ route('renew', $token) }}">
                        {{ route('renew', $token) }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    <footer id="footer">
        <ul class="copyright">
            <li>&copy; MPRadFramework. All rights reserved.</li>
            <li>Desenvolvido por: <a href="https://unixlocal.tk">unix.local</a></li>
        </ul>
    </footer>
</body>

</html>