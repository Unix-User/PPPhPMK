<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Notificação - Unix.Local</title>
    <meta charset="utf-8" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="http://stackpath.bootstrapcdn.com/bootstrap-4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"" />
        <!--[if lte IE 8]><script src=" assets/js/ie/html5shiv.js">
    </script>
    <![endif]-->
        <!--[if lte IE 9]>
    <link rel="stylesheet" href="assets/css/ie9.css" />
    <![endif]-->
        <!--[if lte IE 8]>
    <link rel="stylesheet" href="assets/css/ie8.css" />
    <![endif]-->
    <link rel="stylesheet" href="/assets/css/main.css" />
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css" />
    <!--<script src="http://kit.fontawesome.com/a668bbe4fe.js" crossorigin="anonymous"></script>-->
</head>

<body>
    <div id="page-wrapper">
        <!-- Header -->
        <header id="header">
            <h1 id="logo"><a href="/">IT Services</a></h1>
            <nav id="nav">
                <ul>
                    <li class="dropdown">
                        <a href="/" class="text-capitalize">Home</a>
                        <ul>
                            <li><a href="/logout">Sair</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header>
        <!-- Main -->
    <?php if ($this->view->status == '1') : ?>
        <div id="main" class="wrapper style1">
            <div class="container">
                <header class="major">
                    <h2>Notificação do sistema</h2>

                    <p>
                    <h3>Mantenha sua conta em dia e evite que o serviço seja suspenso por atraso.</h3>
                    Caso o pagamento já tenha sido efetuado descosidere essa mensgem.
                    As notificações serão automaticamente desativadas na pŕoxima checagem após o pagamento da fatura.
                    Desbloqueio em confiança solicitado, aguarde 2 minutos enquanto é reestabelecida a conexão.</p>
                    </header>
            </div>
            <section class="special">
                <div class="box alt">
                    <div class="row uniform">
                        <section class="12u 12u(medium) 12u$(xsmall)">
                            <a href="/users">
                                <span class="icon alt major fa-money"></span></a>
                            <h3>Efetuar pagamentos</h3>
                            <p>Efetue o pagamento por meio de cartões, transferencias, boletos e etc. Ao termino, a conexão é liberada automaticamente</p>
                        </section>
                    </div>
                </div>
            </section>
        </div>
    <?php elseif ($this->view->status == '2') : ?>
        <div id="main" class="wrapper style1">
            <div class="container">
                <header class="major">
                    <h2>Conexão Bloqueada</h2>

                    <p>
                    <h3>O serviço esta temporariamente suspenso por atraso.</h3>
                    Caso o pagamento já tenha sido efetuado entre em contato com o setor de atendimento.
                    As notificações serão automaticamente desativadas na pŕoxima checagem após o pagamento da fatura.
                    Voce não pode solicitar o desbloqueio em confiança no momento.</p>
                    </header>
            </div>
            <section class="special">
                <div class="box alt">
                    <div class="row uniform">
                        <section class="12u 12u(medium) 12u$(xsmall)">
                            <a href="/users">
                                <span class="icon alt major fa-ban"></span></a>
                            <h3>Conexão Bloqueada</h3>
                            <p>Voce pode pagar on-line ou emitir seu boleto em https://unixlocal.ml, ou entrar em contato com nosso setor de atendimento</p>
                        </section>
                    </div>
                </div>
            </section>
        </div>
    <?php else : ?>
        <div id="main" class="wrapper style1">
            <div class="container">
                <header class="major">
                    <h2>Sistema Temporariamente indisponivel</h2>

                    <p>
                    <h3>Nossos técnicos já foram reportados sobre o ocorrido</h3>
                    Caso o problema já tenha sido resolvido descosidere essa mensgem.
                    Retire da tomada seu equipamento e aguarde alguns segundos antes de liga-lo novamente.
                    As rotas para acesso serão automaticamente reestabelecidas dentro de alguns instantes.</p>
                </header>
            </div>
            <section class="special">
                <div class="box alt">
                    <div class="row uniform">
                        <section class="12u 12u$(medium) 12u$(xsmall)">
                            <a class="clean" href="/contact">
                                <span class="icon alt major fa-wrench"></span></a>
                            <h3>Solicitar suporte</h3>
                            <p>Entre em contato para solicitar atendimento ou suporte técnico. Atendimento em horario comercial pelo telefone <a href="https://wa.me/5534988291040">+55(034)98829-1040</a> ou whatsapp (é só clicar no numero)</p>
                        </section>
                    </div>
                </div>
            </section>
        </div>
    <?php endif; ?>
    </div>
            <!-- Footer -->
            <footer id="footer">
                <ul class="icons">
                    <li><a href="https://twitter.com/***REMOVED***" class="icon alt fa-twitter"><span class="label">Twitter</span></a></li>
                    <li><a href="https://wa.me/5534988291040" class="icon alt fa-whatsapp"><span class="label">Whatsapp</span></a></li>
                    <li><a href="https://t.me/***REMOVED***" class="icon alt fa-paper-plane"><span class="label">Telegram</span></a></li>
                    <li><a href="https://github.com/Unix-User" class="icon alt fa-github"><span class="label">GitHub</span></a></li>
                    <li><a href="mailto:***REMOVED***@gmail.com" class="icon alt fa-envelope"><span class="label">Email</span></a></li>
                </ul>
                <ul class="copyright">
                    <li>&copy; MPRadFramework. All rights reserved.</li><li>Desenvolvido por: <a href="/">unix.local</a></li>
                </ul>
            </footer>
    </div>

    <!-- Scripts -->
    <script>
        window.intergramId = "1061417621"
        window.intergramCustomizations = {
            titleClosed: 'Precisa de ajuda?',
            titleOpen: 'Atendimento e Suporte',
            introMessage: 'Seja bem vindo ao serviço de atendimento',
            autoResponse: 'Procurando um atendente disponivel',
            autoNoResponse: 'Não ha atendentes disponiveis no momento ' +
                'Tente mais tarde',
            mainColor: "#e44c65", // Can be any css supported color 'red', 'rgb(255,87,34)', etc
            alwaysUseFloatingButton: true // Use the mobile floating button also on large screens
        };
    </script>
    <script id="intergram" type="text/javascript" src="https://www.intergram.xyz/js/widget.js"></script>
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/jquery.scrolly.min.js"></script>
    <script src="/assets/js/jquery.dropotron.min.js"></script>
    <script src="/assets/js/jquery.scrollex.min.js"></script>
    <script src="/assets/js/skel.min.js"></script>
    <script src="/assets/js/util.js"></script>
    <!--[if lte IE 8]>
    <script src="assets/js/ie/respond.min.js"></script>
    <![endif]-->
    <script src="/assets/js/main.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/assets/js/bootstrap.min.js"></script>
</body>

</html>