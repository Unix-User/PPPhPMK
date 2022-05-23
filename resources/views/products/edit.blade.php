@extends('layouts.default')

@section('title' , 'Editar produto')

@push('styles')
<link rel="stylesheet" href=" {{ mix('css/style.css')}} " />
<style>
    #formImage {
        display: none;
    }

    #fileInput {
        background-color: transparent;
    }
</style>
@endpush


@section('content')
@if ($errors->any())
<div style="width: 100%; position: relative; background-color: #272833; border-color: #843534" class="alert alert-danger alert-dismissable" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    @foreach ($errors->all() as $error)
    <i class="icon fa-exclamation-triangle"></i> {{ $error }}
    @endforeach
</div>
@endif

<div class="col-xs-12 col-xs-offset-0">
    <div>
        <div class="panel-heading">
            <h3 class="panel-title">Editar produto</h3>
        </div>
        <div class="panel-body">
            <form action="/product/{{ $product->id }}/update" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row form-group">
                    <div class=" 8u 6u(medium) 12u$(xsmall) @if($errors->has('name')) has-error @endif">
                        <label for="title" class="control-label">Produto</label>
                        <input type="text" name="name" class="form-control" value="{{ $product->name }}" placeholder="Produto" required>
                        @if ($errors->has('name'))
                        <span class="help-block 10u 6u(medium) 12u$(xsmall)">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class=" 2u 6u(medium) 12u$(xsmall) @if ($errors->has('tags')) has-error @endif">
                        <label for="tags">Rate limit</label>
                        <input type="text" name="tags" class="form-control" value="{{ $product->tags }}" placeholder="Rate limit" required>
                        @if ($errors->has('tags'))
                        <span class="help-block 10u 6u(medium) 12u$(xsmall)">
                            <strong>{{ $errors->first('tags') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class=" 2u 6u(medium) 12u$(xsmall) @if ($errors->has('price')) has-error @endif">
                        <label for="price">Valor</label>
                        <input type="text" name="price" class="form-control" value="{{ $product->price }}" placeholder="Valor" required>
                        @if ($errors->has('price'))
                        <span class="help-block 10u 6u(medium) 12u$(xsmall)">
                            <strong>{{ $errors->first('price') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="row form-group">
                    <div class="fit 10u 6u(medium) 12u$(xsmall) @if ($errors->has('category')) has-error @endif">
                        <label for="title" class="control-label">Descrição</label>
                        <textarea type="text" name="description" placeholder="Descrição" required>{{ $product->description }}</textarea>
                        @if ($errors->has('description'))
                        <span class="help-block 10u 6u(medium) 12u$(xsmall)">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="pull-right 2u 6u(medium) 12u$(xsmall) @if ($errors->has('status')) has-error @endif">
                        <label for="image">Enviar imagem</label>
                        <!-- button for file input -->
                        <button type="button" class="btn clean" id="fileInput">
                            <i class="icon alt major fa-upload" aria-hidden="true"></i>
                        </button>
                        <!-- file input -->
                        <input type="file" name="image" id="formImage" class="form-control">
                        @if ($errors->has('image'))
                        <span class="help-block">
                            <strong>{{ $errors->first('image') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <a href="/products" class="button special small">Cancelar</a>
                    <button type="submit" class="button small">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//malsup.github.io/jquery.form.js"></script>

<script>
    /*função para enviar imagem em form do laravel*/
    $('#fileInput').click(function() {
        $('#formImage').click();
    });
</script>

@endpush