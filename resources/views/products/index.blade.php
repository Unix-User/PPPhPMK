@extends('layouts.default')

@section('title' , 'Produtos')

@push('styles')
@endpush


@section('content')
<header class="major">
    <h2>Produtos</h2>
    <p>Aqui voce obtem informções detalhadas sobre produtos e serviços</p>
</header>
<div>
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
    @if (Auth::check() && Auth::user()->teams->first()->id == '1')
    <div class="panel-body row 50% uniform">
        <a href="/product/create" class="clean icon solid fa-plus special pull-right"></a>
    </div>&nbsp
    @endif
    <div class="card-columns">
        @foreach($products as $product)
        <div class="col">
            <div class="card bg-custom h-100">
                <a class="clean" href="/product/{{  $product->id; }}/show">
                    <img class="card-img-top" src="/images/{{ $product->image }}" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name; }}</h5>
                        <p class="card-text text-truncate">{{ $product->description; }}</p>
                    </div>
                    <div class="d-flex justify-content-center">
                        <small class="text-muted">saiba mais</small>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"> R${{ $product->price; }}</small>
                        <small class="text-muted float-right">
                            @if(Auth::check() && Auth::user()->teams->first()->id == '1')
                            <a class="clean icon solid fa-edit" href="/product/{{ $product->id }}/edit"></a>
                            <a class="clean icon solid fa-trash" href="/product/{{ $product->id }}/delete" onclick="return confirm('Deletar esse intem?')"></a>
                            @else
                            <a class="clean ask icon solid fa-shopping-cart" onclick="" href="/product/{{ $product->id }}/select"></a>
                            @endif
                        </small>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center">
        {{ $products->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
$('.ask').click( function(e) {e.preventDefault(); return confirm('Tem certeza que deseja mudar o seu plano? Ao confirmar seu usuário será designado para o time tecnico especifcado no plano selecionado e um novo contrato será gerado para o seu plano. A ativação será processada ao finalizar o pagamento!')} );
</script>
@endpush