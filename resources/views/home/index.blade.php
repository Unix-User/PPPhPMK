@extends('layouts.default')

@section('title' , 'Inicio')

@push('styles')
<link rel="stylesheet" href=" {{ mix('css/style.css')}} " />
@endpush


@section('content')
<header class="major">
    <?php if ($this->auth->check() && $this->auth->admin()): ?>
        <h2>Bem vindo <span class="text-capitalize"><?php echo $this->auth->name() ?></span></h2>
        <p>Voce tem privilégios administrativos para gerenciar o sistema</p>
    <?php else: ?>
        <h2>Bem vindo<?php echo '<span class="text-capitalize"> ' . $this->auth->name() . '</span>' ?></h2>
        <p>Esta é uma área destinada ao relacionamento com voce, nosso cliente</p>
    <?php endif; ?>
</header>
<!-- Content -->
<section class="special">
    <div class="row">
        <?php $this->renderView('alerts/_success'); ?>
        <?php $this->renderView('alerts/_errors') ?>
    </div>
    <div class="box alt">
        <div class="row uniform">
            <?php if ($this->auth->check() && $this->auth->admin()): ?>
                <section class="3u 6u(medium) 12u$(xsmall)">
                    <a class="clean" href="/users">
                        <span class="icon alt major fa-user"></span></a>
                    <h3>Gerenciar usuários</h3>
                    <p>Altere informações de qualquer usuário, senha ou email de contato.</p>
                </section>
                <section class="3u 6u(medium) 12u$(xsmall)">
                    <a class="clean" href="/products">
                        <span class="icon alt major fa-shopping-cart"></span></a>
                    <h3>Gerenciar produtos</h3>
                    <p>Edite, remova ou cadastre produtos no banco de dados.</p>
                </section>
                <section class="3u 6u$(medium) 12u$(xsmall)">
                    <a class="clean" href="/support">
                        <span class="icon alt major fa-wrench"></span></a>
                    <h3>Visualizar tickets de suporte</h3>
                    <p>Verifique nos registros as ultimas solicitações de suporte técnico.</p>
                </section>
                <section class="3u 6u$(medium) 12u$(xsmall)">
                    <a class="clean" href="/system">
                        <span class="icon alt major fa fa-gear"></span></a>
                    <h3>Gerenciar logs e configurações</h3>
                    <p>Verifique nos registros as ultimas atividades ou modifique suas configurações.</p>
                </section>
            <?php else: ?>
                <section class="4u 6u(medium) 12u$(xsmall)">
                    <a class="clean" href="/user/<?php echo $this->auth->id() ?>/edit">
                        <span class="icon alt major fa-user"></span></a>
                    <h3>Editar dados cadastrais</h3>
                    <p>Altere informações do usuário, senha ou email de contato.</p>
                </section>
                <section class="4u 6u(medium) 12u$(xsmall)">
                    <a class="clean" href="/user/<?php echo $this->auth->id() ?>/show">
                        <span class="icon alt major fa-money-bill-alt"></span></a>
                    <h3>Efetuar pagamentos</h3>
                    <p>Efetue o pagamento por meio de cartões, transferencias, boletos e etc.</p>
                </section>
                <section class="4u$ 6u$(medium) 12u$(xsmall)">
                    <a class="clean" href="/support">
                        <span class="icon alt major fa-wrench"></span></a>
                    <h3>Solicitar suporte</h3>
                    <p>Entre em contato para solicitar atendimento ou suporte técnico.</p>
                </section>
            <?php endif; ?>
        </div>
    </div>
</section>
@endsection