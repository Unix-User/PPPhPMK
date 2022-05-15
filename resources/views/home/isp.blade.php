@extends('layouts.default')

@section('title' , 'ISP')

@push('styles')
<link rel="stylesheet" href=" {{ mix('css/style.css')}} " />
@endpush


@section('content')
<header class="major">
    <h2>Gerenciamento efetivo e disponibilidade</h2>
    <p>Confira algumas informações sobre a aplicação dos processo de gestão e disponibilidade de rede</p>
</header>
<div class="row 150%">
    <div class="8u 12u$(medium)">

        <!-- Content -->
        <section id="content">
            <a href="#" class="image fit"><img src="images/pic04.jpg" alt="" /></a>
            <h3>Consultoria para redes e ISP's</h3>
            <p>Disponibilizamos os melhores processos de gestão para seu ambiente, desenvolvendo se nescessário uma solução customizada de acordo com as preferencias do cliente. Oferecemos soluções para aumento de disponibilidade, escalabilidade e interoperabilidade, <a href="contato.html" >solicite maiores informações.</a></p>
            <p>Desenvolvemos aplicações front-end e back-end para gestão e autenticação de usuários, portal de login hotspot, servidores Windows NPS, Freeradius, VPN, PPTP, PPPoe dentre outras.</p>
            <h3>Alguns exemplos</h3>
            <p>Para atender suas necessidades oferecemos um grande leque de serviços, voce sempre pode <a href="contato.html" >clicar aqui para nos solicitar informações</a>. Abaixo exemplificamos alguns ambientes de aplicação:</p>
            <ul>
                <li>Configuração e instalação de equipamentos</li>
                <li>Desenvolvimento de aplicações back-end, integração com API de pagamento, Boleto, etc...</li>
                <li>Trabalhamos com vários sistemas operacionais e diversas tecnologias.</li>
                <li>Configuração da tabela de roteamento, firewall, loadbalance, failover, VPN...</li>
                <li>Métodos de autenticação, manutenção e gestão de usuários na rede.</li>
            </ul>
        </section>

    </div>
    <div class="4u$ 12u$(medium)">

        <!-- Sidebar -->
        <section id="sidebar">
            <section>
                <h3>Diversas Soluções</h3>
                <p>Oferecemos Soluções diversas para o melhor aproveitamento da sua rede e do seu sistema. Todos os processos de acordo com as melhores práticas estabelecidas e nossas politicas de segurança que vc pode <a href='#'>conferir aqui.</a></p>
                <footer>
                    <ul class="actions">
                        <li><a href="#" class="button">Orçamento</a></li>
                    </ul>
                </footer>
            </section>
            <hr />
            <section>
                <a href="#" class="image fit"><img src="images/pic07.jpg" alt="" /></a>
                <h3>Desenvolvimento e integração</h3>
                <p>Desenvolvemos aplicações, portais hotspot, paineis de gestão, interação de apis de pagamento em boleto/cartão, integração com apis diversas, bancos de dados e etc</p>
                <footer>
                    <ul class="actions">
                        <li><a href="#" class="button">Orçamento</a></li>
                    </ul>
                </footer>
            </section>
        </section>

    </div>
</div>
@endsection