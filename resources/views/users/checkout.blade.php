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
        @foreach ($user->contracts as $contract)
        <div class="card-header">
            <span class="icon alt fa-money"></span>
            <span class="text-capitalize"><strong>Pague com PIX</strong></span>
            </span>
        </div>
        <div class="card-body">
            <img id="qr_code" class="card-img-top" src="data:image/png;base64,{{ $payment->point_of_interaction->transaction_data->qr_code_base64 }}" />
            <!-- mostra input e botão de copiar na mesma linha -->
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="qr_code_input" value="{{ $payment->point_of_interaction->transaction_data->qr_code }}" aria-label="Recipient's username" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" onclick="copyToClipboard('#qr_code_input')">Copiar</button>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <ul class="actions">
                <li><a href="/products" class="button">Trocar</a></li>
            </ul>
        </div>
        @endforeach
    </div>
    <div class="card col-sm-8 bg-custom">
        <div class="card-header">
            <span class="icon alt fa-user"></span>
            <strong class="text-capitalize">{{ $contract->name }}</strong>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <img class="card-img-top" src="/images/{{ $contract->image }}" alt="Card image cap">
                </div>
                <div class="col-md-8">
                    <p class="card-text">{{ $contract->description }}</p>
                    <p class="card-text"><small class="text-muted">Técnico: <a href="/user/{{ $contract->user->id }}/show">{{ $contract->user->name }}</a></small></p>
                    <p class="card-text"><small class="text-muted">R${{ $contract->price }}</small></p>
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
    const mp = new MercadoPago('{{env("MP_PUB_KEY")}}', {
        locale: 'pt-BR'
    });


    const checkout = mp.checkout({
        preference: {
            id: '{{ $preference->id }}'
        }
    });
</script>
@endprepend