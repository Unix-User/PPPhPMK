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
        <div class="card-header">
            <span class="icon alt fa-money"></span>
            <span class="text-capitalize"><strong>Pague com PIX</strong></span>
            </span>
        </div>
        <div class="card-body">
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
        <div class="card-footer">
            <ul class="actions">
                <li><a href="/products" class="button">Trocar</a></li>
            </ul>
        </div>
    </div>

    <div class="card col-sm-8 bg-custom">
        <div class="card-header">
            <span class="icon alt fa-user"></span>
            <strong class="text-capitalize">{{ $user->contracts->last()->name }}</strong>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img class="card-img-top" src="/images/{{ $user->contracts->last()->image }}" alt="Card image cap">
                </div>
                <div class="col-md-8">

                    <p class="card-text">{{ $user->contracts->last()->description }}<br />{{ $user->contracts->last()->id }}<br />{{ $preference->external_reference }}<br />{{ $payment->external_reference }}</p>
                    <p class="card-text"><small class="text-muted">Técnico: <a href="/user/{{ $user->contracts->last()->user->id }}/show">{{ $user->contracts->last()->user->name }}</a></small></p>
                    <p class="card-text"><small class="text-muted">R${{ $user->contracts->last()->price }}</small></p>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <ul class="actions">
                <li>
                    <input type="button" onclick="checkout.open()" value="Pagar">
                </li>
            </ul>
        </div>
    </div>
</div>
<pre>
    <code style="color: #FFF;">{{ $log }}</code>
</pre>

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
    const mp = new MercadoPago('{{env("Test_MP_PUB_KEY")}}', {
        locale: 'pt-BR'
    });


    const checkout = mp.checkout({
        preference: {
            id: '{{ $preference->id }}'
        }
    });
</script>
@endprepend