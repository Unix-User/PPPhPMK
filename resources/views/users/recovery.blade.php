@extends('layouts.default')

@section('title' , 'Recuperação de senha')

@push('styles')
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-custom">
                <div class="card-header">{{ __('Recuperação de senha') }}</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <form method="POST" action="/user/reset">
                        @csrf
                        <div class="form-outline mb-4">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <label for="email" class="form-label">{{ __('E-Mail') }}</label>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <button type="submit" class="button special btn-block mb-4">{{ __('Enviar') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection