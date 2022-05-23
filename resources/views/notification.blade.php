@extends('layouts.default')

@section('title' , '{{ $user->name }}')

@push('styles')
@endpush

@section('content')
@switch($status)
@case('1')
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
            <div class="col uniform">
                <section class="12u 12u(medium) 12u$(xsmall)">
                    <a href="/users">
                        <span class="icon solid alt major fa-money-bill-alt"></span></a>
                    <h3>Efetuar pagamentos</h3>
                    <p>Efetue o pagamento por meio de cartões, transferencias, boletos e etc. Ao termino, a conexão é liberada automaticamente</p>
                </section>
            </div>
        </div>
    </section>
</div>
@break
@case('2')
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
            <div class="col uniform">
                <section class="12u 12u(medium) 12u$(xsmall)">
                    <a href="/users">
                        <span class="icon solid alt major fa-ban"></span></a>
                    <h3>Conexão Bloqueada</h3>
                    <p>Voce pode pagar on-line ou emitir seu boleto em https://unixlocal.ml, ou entrar em contato com nosso setor de atendimento</p>
                </section>
            </div>
        </div>
    </section>
</div>
@break
@case('3')
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
            <div class="col uniform">
                <section class="12u 12u$(medium) 12u$(xsmall)">
                    <a class="clean" href="/contact">
                        <span class="icon solid alt major fa-wrench"></span></a>
                    <h3>Solicitar suporte</h3>
                    <p>Entre em contato para solicitar atendimento ou suporte técnico. Atendimento em horario comercial pelo telefone <a href="https://wa.me/5534988291040">+55(034)98829-1040</a> ou whatsapp (é só clicar no numero)</p>
                </section>
            </div>
        </div>
    </section>
</div>
@break
@default
<div id="main" class="wrapper style1">
    <div class="container">
        <header class="major">
            <h2>Erro</h2>
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
                        <span class="icon solid alt major fa-wrench"></span></a>
                    <h3>Solicitar suporte</h3>
                    <p>Entre em contato para solicitar atendimento ou suporte técnico. Atendimento em horario comercial pelo telefone <a href="https://wa.me/5534988291040">+55(034)98829-1040</a> ou whatsapp (é só clicar no numero)</p>
                </section>
            </div>
        </div>
    </section>
</div>
@break
@endswitch
@endsection