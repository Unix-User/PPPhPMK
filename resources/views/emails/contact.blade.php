<!DOCTYPE html>
<html>

<head>
    <title>Recuperação de senha</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="stylesheet" type="text/css" href="{{ mix('css/main.css')}}" />
</head>

<body>
    <div id="page-wrapper">
        <!-- Header -->
        <header id="header">
            <h1 id="logo">Recuperação de senha</h1>

            <nav id="nav">
                <ul>
                    <!-- if user is logged in, show dropdown with 3 links -->
                    <li><a href="https://unixlocal.tk/products">Produtos</a></li>
                    <li><a href="https://unixlocal.tk/users">Pessoas</a></li>
                    <li><a href="https://unixlocal.tk/contact">Contato</a></li>
                </ul>
            </nav>
        </header>
        <!-- Main -->
        <div id="main" class="wrapper style1">
            <div class="container">
                <h1>{{ $data['category'] }}</h1>
                <p>{{ __('Essa mensagem foi enviada por:') }} {{ $data['name'] }}</p>

                <p>{{ $data['message'] }}</p>
                <p>{{ __('Favor responder para:') }} {{ $data['email'] }}</p>
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
                <li>Desenvolvido por: <a href="https://unixlocal.tk/">unix.local</a></li>
            </ul>
        </footer>
    </div>
</body>

</html>