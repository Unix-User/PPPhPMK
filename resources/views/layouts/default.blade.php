<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ config('app.name', 'UnixLocal') }}</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href=" {{ mix('css/main.css')}} " />
    @stack('styles')
    <script src="https://kit.fontawesome.com/a668bbe4fe.js" crossorigin="anonymous"></script>
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
                <li><a href="https://twitter.com/***REMOVED***" class="icon alt fa-twitter"><span class="label">Twitter</span></a></li>
                <li><a href="https://wa.me/5534988291040" class="icon alt fa-whatsapp"><span class="label">Whatsapp</span></a></li>
                <li><a href="https://t.me/***REMOVED***" class="icon alt fa-telegram"><span class="label">Telegram</span></a></li>
                <li><a href="https://github.com/Unix-User" class="icon alt fa-github"><span class="label">GitHub</span></a></li>
                <li><a href="mailto:***REMOVED***@gmail.com" class="icon alt fa-envelope"><span class="label">Email</span></a></li>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="{{mix('js/jquery.scrolly.min.js')}}"></script>
    <script src="{{mix('js/jquery.dropotron.min.js')}}"></script>
    <script src="{{mix('js/jquery.scrollex.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/skel/3.0.1/skel.min.js"></script>
    <script src="{{mix('js/util.js')}}"></script>
    <!--[if lte IE 8]>
        <script src="assets/js/ie/respond.min.js"></script>
        <![endif]-->
    <script src="{{mix('js/main.js')}}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{mix('js/bootstrap.min.js')}}"></script>
    @stack('scripts')
</body>
</html>