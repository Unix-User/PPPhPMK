@extends('layouts.default')

@section('title' , 'Produtos')

@push('styles')
<link rel="stylesheet" href=" {{ mix('css/style.css')}} " />
@endpush


@section('content')
<header class="major">
    <h2>Produtos</h2>
    <p>Aqui voce obtem informções detalhadas sobre produtos e serviços</p>
</header>
<div>
    <!-- if any alert messages -->
    @if(session()->has('success'))
    <div class="alert alert-success" style="width: 100%; position: relative; background-color: #272833; border-color: #155724" role="alert">
        {{ session()->get('success') }}
        <!-- close alert button -->
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if(session()->has('error'))
    <div class="alert alert-danger" style="width: 100%; position: relative; background-color: #272833; border-color: #843534" role="alert">
        {{ session()->get('error') }}
        <!-- close alert button -->
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="panel-body row 50% uniform">
        <a href="/product/create" class="clean icon fa-plus special pull-right"></a>
    </div>&nbsp
    <div class="card-columns">
        @foreach($products as $product)
        <div class="col">
            <div class="card bg-custom h-100">
                <a class="clean" href="/product/{{  $product->id; }}/show">
                    <img class="card-img-top" src="/images/{{ $product->image }}" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name; }}</h5>
                        <p class="card-text">{{ $product->description; }}
                            <br />Técnico: <a href="/user/{{ $product->user->id }}/show">{{ $product->user->name }}</a>
                        </p>
                        <p class="card-text"><small class="text-muted"> R${{ $product->price; }}</small></p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted float-end">
                            <a class="clean icon fa-edit" href="/product/{{ $product->id }}/edit"></a>
                            <a class="clean icon fa-trash" href="/product/{{ $product->id }}/delete" onclick="return confirm('Deletar esse intem?')"></a>
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
    @endsection

    @push('scripts')

    @endpush