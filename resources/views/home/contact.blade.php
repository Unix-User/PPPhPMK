@extends('layouts.default')

@section('title' , 'Recuperação de senha')

@push('styles')
<link rel="stylesheet" href=" {{ mix('css/style.css')}} " />
@endpush

@section('content')
<div>
    <header class="major">
        <h2>Contato</h2>
        <h3>Estamos aguardando o seu contato!</h3>
        <p>Preencha abaixo um formulario para contato direto conosco, se preferir, disponibilizamos atendimento pelo <a href="https://wa.me/5534988291040">whatsapp</a> ou ligue para (34)98829-1040 em horario comercial.</p>
    </header>
</div>
<span id="form"></span>
<!-- Form -->
<section>
    @if(session()->has('success'))
    <div class="alert alert-success" style="width: 100%; position: relative; background-color: #272833; border-color: #155724" role="alert">
        {{ session()->get('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if(session()->has('error'))
    <div class="alert alert-danger" style="width: 100%; position: relative; background-color: #272833; border-color: #843534" role="alert">
        {{ session()->get('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div style="margin: 60px">
        <h3>Mensagem</h3>
        <form method="post" action="send">
            @csrf
            @method('POST')
            <div class="row uniform 80%">
                <div class="6u 12u$(xsmall)">
                    <input type="text" name="name" id="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" placeholder="Nome" />
                </div>
                <div class="6u$ 12u$(xsmall)">
                    <input type="email" name="email" id="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" placeholder="Email" />
                </div>
                <div class="12u$">
                    <div class="select-wrapper">
                        <select name="category" id="category">
                            <option value="">Selecione o assunto</option>
                            <option value="Recuperar senha">Recuperar senha</option>
                            <option value="Suporte técnico">Suporte técnico</option>
                            <option value="Orçamento">Orçamento</option>
                            <option value="Duvidas">Duvidas</option>
                            <option value="Reclamação">Reclamação</option>
                            <option value="Outros">Outros</option>
                        </select>
                    </div>
                </div>
                <div class="12u$">
                    <textarea name="message" id="message" placeholder="Digite sua mensagem" rows="6"></textarea>
                </div>
                <div class="12u$">
                    <ul class="actions">
                        <li><input type="submit" value="Enviar Mensagem" class="special" /></li>
                        <li><input type="reset" value="Limpar" /></li>
                    </ul>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection