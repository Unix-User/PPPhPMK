<?php
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off') {
    $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $redirect);
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title><?php echo $this->getPageTitle('-'); ?>Unix.Local</title>
    <meta charset="utf-8" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"" />
        <!--[if lte IE 8]><script src=" assets/js/ie/html5shiv.js">
    </script>
    <![endif]-->
        <link rel="stylesheet" href="/assets/css/main.css" />
        <!--[if lte IE 9]>
    <link rel="stylesheet" href="assets/css/ie9.css" />
    <![endif]-->
        <!--[if lte IE 8]>
    <link rel="stylesheet" href="assets/css/ie8.css" />
    <![endif]-->
    <script src="https://kit.fontawesome.com/a668bbe4fe.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div id="page-wrapper">
            <!-- Header -->
            <header id="header">
                <h1 id="logo"><a href="/">IT Services</a></h1>
                <?php require_once __DIR__ . '/menu.phtml' ?>
            </header>
            <!-- Main -->
            <div id="main" class="wrapper style1">
                <div class="container">
                    <?php $this->content(); ?>
                </div>
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
                    <li>&copy; MPRadFramework. All rights reserved.</li><li>Desenvolvido por: <a href="/">unix.local</a></li>
                </ul>
            </footer>

        </div>

        <!-- Scripts -->
        <script> window.intergramId = "-1001605193657"
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