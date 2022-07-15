@extends('layouts.default')

@section('title' , 'Dispositivos')

@push('styles')

@endpush


@section('content')
<header class="major">
    <h2>Conectar o dispositivo</h2>
    <p>Para conectar seu dispositivo siga as instruções abaixo</p>
</header>
<p>Para configurar automaticamente execute o seguinte codigo no terminal de sua routerboard:</p>

<div class="input-group">
    <input type="text" class="form-control" id="command" value="/tool fetch url={{ env('APP_URL') }}/api/register/{{ $device->ikev2 }} dst-path=ispapp.rsc; /import ispapp.rsc" aria-label="Copy and paste on your device terminal" aria-describedby="basic-addon2">
    <div class="input-group-append">
        <button class="btn btn-outline-secondary" onclick="copyToClipboard('#command')">Copiar</button>
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