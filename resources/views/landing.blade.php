<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ config('app.name', 'UnixLocal') }}</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" href=" {{ mix('css/main.css')}} " />
    <link rel="stylesheet" href=" {{ mix('css/style.css')}} " />
    <script src="https://kit.fontawesome.com/a668bbe4fe.js" crossorigin="anonymous"></script>
</head>

<body class="landing">
    <div id="page-wrapper">
        <!-- Header - Menu superior -->
        <header id="header">
            <h1 id="logo"><a href="#">IT Services</a></h1>
            <nav id="nav">
                <!-- Menu do topo -->
                <ul>
                    <li><a href="/contact">Contato</a></li>
                    <li><a href="/products" class="button special">Clientes</a></li>
                </ul>
                <!-- Fim menu do topo -->
            </nav>
        </header>

        <!-- Banner -->
        <section id="banner">
            <div class="content">
                <header>
                    <h2>O Futuro chegou</h2>
                    <p>E não existem pranchas ou carros voadores.<br />
                        Somente Aplicativos, e várias outras páginas e coisas na internet.</p>
                </header>
                <span class="image"><img src="images/20220511225443.jpg" alt="" /></span>
            </div>
            <a href="#one" class="goto-next scrolly">Next</a>
        </section>

        <!-- One - Apresentação -->
        <section id="one" class="spotlight style1 bottom">
            <span class="image fit main"><img src="images/20220511225443.jpg" alt="" /></span>
            <div class="content">
                <div class="container">
                    <div class="row">
                        <div class="4u 12u$(medium)">
                            <header>
                                <h2>Suporte técnico</h2>
                                <p>De computadores, servidores, redes, hardware e software em geral</p>
                            </header>
                        </div>
                        <div class="4u 12u$(medium)">
                            <p>Mantenha seus sistemas e dispositivos sempre funcionando e atualizados, buscamos atender
                                plenamente suas nescessidades sem pesar o orçamento final ou compremeter a segurança
                                do dispositivo ou sistema.</p>
                        </div>
                        <div class="4u$ 12u$(medium)">
                            <p>Visamos disponibilizar agilidade no atendimento por isso trabalhamos com servidor
                                automatizado para a implantação de sistemas operacionais de forma padronizada,
                                adequando ao ambiente de aplicação, customizando de acordo com as nescessidades do cliente.</p>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#two" class="goto-next scrolly">Next</a>
        </section>

        <!-- Two - Desenvolvimento -->
        <section id="two" class="spotlight style2 right">
            <span class="image fit main"><img src="images/20220511225443.jpg" alt="" /></span>
            <div class="content">
                <header>
                    <h2>Desenvolvimento Web e aplicações mobile</h2>
                    <p>Para sua empresa ingressar na era digital</p>
                </header>
                <p>Desenvolvemos a sua pagina web para divulgação ou contato empresarial.
                    Aplicações web responsivas, mobile ou android, e
                    aplicações back end para servidores, e bancos de dados.</p>
                <ul class="actions">
                    <li><a href="/development" class="button">Saiba Mais</a></li>
                </ul>
            </div>
            <a href="#three" class="goto-next scrolly">Next</a>
        </section>

        <!-- Three - Redes, ISP, Suporte e consultoria -->
        <section id="three" class="spotlight style3 left">
            <span class="image fit main bottom"><img src="images/20220511225443.jpg" alt="" /></span>
            <div class="content">
                <header>
                    <h2>Integração hotspot/pppoe + Mercado Pago</h2>
                    <p>Uma aplicação que gerencia clientes e recebe faturas</p>
                </header>
                <p>Site responsivo para gerenciamento automatizado de clientes de hotspot ou pppoe em dispositivos RADIUS. Libere suas conexões mediante pagamento, receba seus valores pelo Mercado Pago</p>
                <ul class="actions">
                    <li><a href="/isp" class="button">Saiba Mais</a></li>
                </ul>
            </div>
            <a href="#four" class="goto-next scrolly">Next</a>
        </section>

        <!--Four - Nossas vantagens -->
        <section id="four" class="wrapper style1 special fade-up">
            <div class="container">
                <header class="major">
                    <h2>Informatizamos a sua empresa</h2>
                    <p>Por que informatizar o meu negócio? Abaixo, alguns pontos que podem ajudar na tomada de decisão</p>
                </header>
                <div class="box alt">
                    <div class="row uniform">
                        <section class="4u 6u(medium) 12u$(xsmall)">
                            <span class="icon alt major fa-chart-area"></span>
                            <h3>Aumente a efiácia</h3>
                            <p>Em uma ferramenta informatizada vc tem um ágil controle sobre sua podrução e gestão do négócio, poupa tempo e maximiza lucros</p>
                        </section>
                        <section class="4u 6u$(medium) 12u$(xsmall)">
                            <span class="icon alt major fa-comment"></span>
                            <h3>Mantenha contato</h3>
                            <p>Centralize informações da empresa para contato e/ou mantenha um canal direto com o cliente sem inteferencias.</p>
                        </section>
                        <section class="4u$ 6u(medium) 12u$(xsmall)">
                            <span class="icon alt major fa-search"></span>
                            <h3>Visibilidade e marketing</h3>
                            <p>Sua empresa, produto ou serviço fica visivel no mundo pela internet, informa sobre campanhas publicitárias e promoções.</p>
                        </section>
                        <section class="6u 6u(medium) 12u$(xsmall)">
                            <span class="icon alt major fa-money-bill-alt"></span>
                            <h3>Meios de pagamento facilitados</h3>
                            <p>Receba por meios de pagamento informatizados como cartões, transferencias, boletos, aplicativos de pagamento e etc.</p>
                        </section>
                        <section class="6u 6u$(medium) 12u$(xsmall)">
                            <span class="icon alt major fa-lock"></span>
                            <h3>Segurança em foco</h3>
                            <p>Utilize a nuvem para proteger e armazenar seus dados, integre sistemas de segurança para monitoramento on-line como alarmes e cameras.</p>
                        </section>
                    </div>
                </div>
                <footer class="major">
                    <ul class="actions">
                        <li><a href="/client" class="button">Área do cliente</a></li>
                    </ul>
                </footer>
            </div>
        </section>
    </div>
    <!-- Footer -->
    <footer id="footer">
        <ul class="icons">
            <li><a href="https://twitter.com/wevertonslima" class="icon alt fa-twitter"><span class="label">Twitter</span></a></li>
            <li><a href="https://wa.me/5534988291040" class="icon alt fa-whatsapp"><span class="label">Whatsapp</span></a></li>
            <li><a href="https://t.me/wevertonslima" class="icon alt fa-telegram"><span class="label">Telegram</span></a></li>
            <li><a href="https://github.com/Unix-User" class="icon alt fa-github"><span class="label">GitHub</span></a></li>
            <li><a href="mailto:wevertonslima@gmail.com" class="icon alt fa-envelope"><span class="label">Email</span></a></li>
        </ul>
        <ul class="copyright">
            <li>&copy; MPRadFramework. All rights reserved.</li>
            <li>Desenvolvido por: <a href="/">unix.local</a></li>
        </ul>
    </footer>
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
    <script src="{{mix('/js/jquery.scrolly.min.js')}}"></script>
    <script src="{{mix('/js/jquery.dropotron.min.js')}}"></script>
    <script src="{{mix('/js/jquery.scrollex.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/skel/3.0.1/skel.min.js"></script>
    <script src="{{mix('/js/util.js')}}"></script>
    <!--[if lte IE 8]>
        <script src="assets/js/ie/respond.min.js"></script>
        <![endif]-->
    <script src="{{mix('/js/main.js')}}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{mix('/js/bootstrap.min.js')}}"></script>
</body>