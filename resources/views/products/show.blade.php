@extends('layouts.default')

@section('title' , '{{ $product->name }}')

@push('styles')
@endpush

@section('content')

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
<header class="major">
    <h2>{{ $product->name }}</h2>
</header>
<!-- card with image placed left -->
<div class="card bg-custom">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <img class="card-img-top" src="/images/{{ $product->image }}" alt="Card image cap">
            </div>
            <div class="col-md-8">
                <p class="card-text">{{ $product->description }}</p>
                <p class="card-text"><small class="text-muted">Técnico: <a href="/user/{{ $product->user->id }}/show">{{ $product->user->name }}</a></small></p>
                <p class="card-text"><small class="text-muted">R${{ $product->price }}</small></p>
                <!-- if user is logged in display buy button -->
                @if (Auth::check())
                <a href="/product/{{ $product->id }}/select" class="btn btn-primary">Comprar</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
