@extends('layouts.default')

@section('title' , '{{ $user->name }}')

@push('styles')

@endpush

@section('content')
<header class="major">
    <h2>Confirme seu pagamento <span class="text-capitalize">{{ $user->name }}</span>!</h2>
    <p>Agora basta efetuar o pagamento de sua fatura para liberar a sua internet</p>
</header>
<!-- Content -->
<div class="card-deck">
    <div class="card col-sm-4 bg-custom">
        <a class="clean" href="/product/{{  $user->contracts->last()->product->id; }}/show">
            <div class="card-header">
                <span class="icon alt fa-wifi"></span>
                <strong class="text-capitalize">{{ $user->contracts->last()->product->name }}</strong>
            </div>
            <img class="card-img-top" src="/images/{{ $user->contracts->last()->product->image }}" alt="Card image cap">
            <div class="card-body">
                <p class="card-text">{{ $user->contracts->last()->product->description; }}</p>
            </div>
            <div class="card-footer">
                <ul class="actions">
                    <li><a href="/products" class="button">Selecionar outro plano</a></li>
                </ul>
            </div>
        </a>
    </div>
    <div class="card col-sm-8 bg-custom">
        <div class="card-header">
            <span class="icon alt fa-money"></span>
            <span class="text-capitalize"><strong>Pagamento on-line - Boleto, Cartões, PIX</strong></span>
            </span>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <p class="card-text">O pagamento será processado pelo <a class="clean" target="_blank" href="https://mercadopago.com.br">MercadoPago</a>, nenhum dado alem do nescessario para a liberação da conexão será armazenado no servidor. A conexão será liberada imediatamente após a confirmação do recebimento e terá validade de 30 dias
                        <small class="text-muted">
                            <br />Data de aquisição:
                            <br />{{ $user->contracts->last()->created_at->format('d/m/Y') }}
                            <br />Referencia do contrato:
                            <br />{{ $preference->external_reference }}
                        </small>
                    </p>
                </div>
                <div class="col-md-4">
                    @if($payment->point_of_interaction)
                    <img id="qr_code" class="card-img-top" src="data:image/png;base64,{{ $payment->point_of_interaction->transaction_data->qr_code_base64 }}" />
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="qr_code_input" value="{{ $payment->point_of_interaction->transaction_data->qr_code }}" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" onclick="copyToClipboard('#qr_code_input')">Copiar</button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer">
            <ul class="actions">
                <li>
                    <input type="button" onclick="checkout.open()" value="Pagar">
                </li>
                <li class="float-right align-bottom">
                    <h1 class="h1 text-right">R${{ $user->contracts->last()->product->price }}</h1>
                    <small class="float-right text-muted">Resp. técnico: {{ $user->contracts->last()->product->user->name }}</small>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<!-- copy qr_code_input value to clipboard -->
<script>
    function copyToClipboard(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).val()).select();
        document.execCommand("copy");
        $temp.remove();
    }
</script>
@endpush

@prepend('scripts')
<!-- Add step #2 -->
<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>
    // Adicione as credenciais do SDK


    const mp = new MercadoPago('{{ $key }}', {
        locale: 'pt-BR'
    });


    const checkout = mp.checkout({
        preference: {
            id: '{{ $preference->id }}'
        }
    });
</script>
@endprepend