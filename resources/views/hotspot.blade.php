<!-- $(if chap-id) -->
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Unix.Local</title>
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


<form name="sendin" action="<?php echo $this->view->hotspot['linkloginonly']; ?>" method="post">
    <input type="hidden" name="username" />
    <input type="hidden" name="password" />
    <input type="hidden" name="dst" value="<?php echo $this->view->hotspot['linkorig']; ?>" />
    <input type="hidden" name="popup" value="true" />
</form>

<script type="text/javascript" src="/assets/js/md5.js"></script>
<script type="text/javascript">
	    function doLogin() {
                <?php if (strlen($this->view->hotspot['chapid']) < 1) echo "return true;\n"; ?>
        document.sendin.username.value = document.login.username.value;
		document.sendin.password.value = hexMD5('<?php echo $this->view->hotspot['chapid']; ?>' + document.login.username.value + '<?php $this->view->hotspot['chapchallenge']; ?>');
		document.sendin.submit();
		return false;
	    }
</script>
<!-- $(endif) -->
<div id="page-wrapper">
            <!-- Header -->
            <header id="header">
				<h1 id="logo"><a href="/">IT Services</a></h1>
            </header>
            <!-- Main -->
            <div id="main" class="wrapper style1">
                <div class="container">
<div class="row">
    <div class="col-xs-12 col-xs-offset-0 col-md-4 col-md-offset-4">
        <div>
            <div class="panel-heading">
                <h3 style="color: #FF8080" class="panel-title"><?php echo $this->view->hotspot['error']; ?></h3>
                <h3 class="panel-title">Digite o nome de usuário e a senha</h3>
            </div>
            <div class="panel-body">
                <form name="login" action="<?php echo $this->view->hotspot['linkloginonly']; ?>" method="post" accept-charset="utf8">
                    <input type="hidden" name="dst" value="<?php echo $this->view->hotspot['linkorig']; ?>" />
                    <input type="hidden" name="popup" value="true" />

                    <div class="form-group">
                        <label for="username" class="control-label">Nome</label>
                        <input type="text" name="username" class="form-control" value="<?php echo isset($this->view->hotspot['username']) ? $this->view->hotspot['username'] : $this->view->user->name; ?>" />
                    </div>
                    <div class="form-group">
                        <label for="password" class="control-label">Senha</label>
                        <input type="password" name="password" class="form-control" value="1234" />
                    </div>
                    <ul class="actions">
                        <li><button type="submit" class="button special">
                                <i class="glyphicon glyphicon-log-in" aria-hidden="true"></i> Entrar
                            </button></li>
                        <li><a href="https://unixlocal.ml/user/create">Ainda não é cadastrado?</a></li>
                        <li><a href="https://unixlocal.ml//contact">Esqueci minha senha</a></li>
                        <li><a href="<?php echo $this->view->hotspot['linkloginonly']; ?>?dst=<?php echo $this->view->hotspot['linkorigesc']; ?>&username=T-<?php echo $this->view->hotspot['macesc']; ?>">Teste o sistema</a></li>
                    </ul>

                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.login.username.focus();
    document.login.submit();
</script>

</div>
            </div>
            <!-- Footer -->
            <footer id="footer">
                <ul class="icons">
                    <li><a href="https://twitter.com/wevertonslima" class="icon alt fa-twitter"><span class="label">Twitter</span></a></li>
                    <li><a href="https://t.me/wevertonslima" class="icon alt fa-telegram"><span class="label">Telegram</span></a></li>
                    <li><a href="https://github.com/Unix-User" class="icon alt fa-github"><span class="label">GitHub</span></a></li>
                    <li><a href="mailto:wevertonslima@gmail.com" class="icon alt fa-envelope"><span class="label">Email</span></a></li>
                </ul>
                <ul class="copyright">
                    <li>&copy; RadiusMicroframework. All rights reserved.</li><li>Desenvolvido por: <a href="/">unix.local</a></li>
                </ul>
            </footer>

        </div>

        <!-- Scripts -->
        <script> window.intergramId = "1061417621"
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