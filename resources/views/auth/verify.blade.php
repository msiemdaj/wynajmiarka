@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Zweryfikuj swoje konto') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Nowy link aktywacyjny został wysłany na podany przez Ciebie adres email.') }}
                        </div>
                    @endif

                    {{ __('Zanim zaczniesz używać tej funkcji, prosimy o potwierdzenie konta. W tym celu sprawdź skrzynkę email w poszukiwaniu wiadomości z linkiem aktywacyjnym.') }}
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Jeśli wiadomość z linkiem aktywacyjnym nie dotarła kliknij tutaj, aby wysłać ją ponownie') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
