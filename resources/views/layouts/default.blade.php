<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ config('app.name', 'UnixLocal') }}</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!--- bootstrap --->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!--- estilos do template --->
    <link rel="stylesheet" href=" {{ mix('css/main.css')}} " />
    <link rel="stylesheet" href=" {{ mix('css/style.css')}} " />
    <link rel="stylesheet" href=" {{ mix('css/fontawesome-all.min.css')}} " />
    <noscript>
        <link rel="stylesheet" href="assets/css/noscript.css" />
    </noscript>
    @stack('styles')
</head>

<body>
    <div id="page-wrapper">
        <!-- Header -->
        <header id="header">
            <h1 id="logo"><a href="/">IT Services</a></h1>
            @section('menu')
            <nav id="nav">
                <ul>
                    <!-- if user is logged in, show dropdown with 3 links -->
                    @if (Auth::check())
                    <li><a href="/products">Produtos</a></li>
                    <li><a href="/users">Pessoas</a></li>
                    <li><a href="#">Sistema</a></li>
                    <li><a href="#">Suporte</a></li>
                    <li class="dropdown">
                        <a href="#" class="text-capitalize">{{ Auth::user()->name }}</a>
                        <ul>
                            <li><a href="/users ">Inicio</a></li>
                            <li><a href="/user/{{ Auth::id() }}/show ">Perfil</a></li>
                            <li><a href="/devices">Dispositivos</a></li>
                            <li><a href="/logout">Sair</a></li>
                        </ul>
                    </li>
                    @else
                    <li><a href="/contact">Contato</a></li>
                    <li><a class="button" href="/login">Entrar</a></li>
                    <li><a class="button special" href="/user/create">Registre-se</a></li>
                    @endif
                </ul>
            </nav>
            @show
        </header>
        <!-- Main -->
        <div id="main" class="wrapper style1">
            <div class="container">
                @yield('content')
            </div>
        </div>
        <!-- Footer -->
        <footer id="footer">
            <ul class="icons">
                <li><a href="https://twitter.com/wevertonslima" class="icon brands alt fa-twitter"><span class="label">Twitter</span></a></li>
                <li><a href="https://wa.me/5534988291040" class="icon brands alt fa-whatsapp"><span class="label">Whatsapp</span></a></li>
                <li><a href="#" class="icon brands alt fa-linkedin-in"><span class="label">LinkedIn</span></a></li>
                <li><a href="https://t.me/wevertonslima" class="icon brands alt fa-telegram"><span class="label">Telegram</span></a></li>
                <li><a href="https://github.com/Unix-User" class="icon brands alt fa-github"><span class="label">GitHub</span></a></li>
                <li><a href="mailto:wevertonslima@gmail.com" class="icon solid alt fa-envelope"><span class="label">Email</span></a></li>
            </ul>
            <ul class="copyright">
                <li>&copy; MPRadFramework. All rights reserved.</li>
                <li>Desenvolvido por: <a href="/">unix.local</a></li>
            </ul>
        </footer>

    </div>

    <!-- Scripts -->
    <script>
        window.intergramId = "-1001605193657"
        window.intergramServer = "https://unixat.herokuapp.com"
        window.intergramCustomizations = {
            titleClosed: 'Precisa de ajuda?',
            titleOpen: 'Atendimento e Suporte',
            introMessage: 'Seja bem vindo ao serviço de atendimento',
            autoResponse: 'Procurando um atendente disponivel',
            autoNoResponse: 'Nenhum atendente disponivel no momento ' +
                'Tente novamente em alguns minutos',
            mainColor: "#e44c65", // Can be any css supported color 'red', 'rgb(255,87,34)', etc
            alwaysUseFloatingButton: true // Use the mobile floating button also on large screens
        };
    </script>
    <script id="intergram" type="text/javascript" src="https://unixat.herokuapp.com/js/widget.js"></script>
    <!-- <script id="intergram" type="text/javascript" src="https://www.intergram.xyz/js/widget.js"></script> -->
    <!--- bootstrap --->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <!-- scripts do template -->
    <script src="{{mix('js/jquery.min.js')}}"></script>
    <script src="{{mix('js/jquery.scrolly.min.js')}}"></script>
    <script src="{{mix('js/jquery.dropotron.min.js')}}"></script>
    <script src="{{mix('js/jquery.scrollex.min.js')}}"></script>
    <script src="{{mix('js/breakpoints.min.js')}}"></script>
    <script src="{{mix('js/browser.min.js')}}"></script>
    <script src="{{mix('js/util.js')}}"></script>
    <script src="{{mix('js/main.js')}}"></script>
    @stack('scripts')
</body>

</html>