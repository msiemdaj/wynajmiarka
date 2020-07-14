@extends('layouts/app')

@section('content')

  @if(session('message'))
    <div class="alert alert-success alert-dismissible fade show spce-1-t-alert" role="alert">
    {{ session('message') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif

  <div class="simpl-head">
    <h2>Ustawienia</h2>
    <h4>Tutaj możesz zmienić ustawienia swojego konta. Dane do logowania, kontakt, otrzymywanie powiadomień lub możesz zdezaktywować swoje konto</h4>
  </div>

      <div class="bezp-set">
          <h2>Bezpieczeństwo</h2>
          <h4>Tutaj możesz zmienić swoje hasło do konta</h4>
          <hr>
          {!! Form::open(['action' => ['UstawieniaController@security'],
                          'method' => 'PUT']) !!}
                          @csrf
                          <div class="form-group">
                            {{ Form::label('currentpassword', 'Obecne hasło') }}
                            {{-- {{ Form::password('currentpassword', null, ['class' => 'form-control']) }} --}}
                            <input type="password" name="currentpassword" class="form-control @error('currentpassword') is-invalid @enderror">
                            @error('currentpassword')
                              <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                          </div>
                          <div class="form-group">
                            {{ Form::label('newpassword', 'Nowe hasło') }}
                            {{-- {{ Form::password('newpassword', null, ['class' => 'form-control']) }} --}}
                            <input type="password" name="newpassword" class="form-control @error('newpassword') is-invalid @enderror">
                            @error('newpassword')
                              <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                          </div>
                          <div class="form-group">
                            {{ Form::label('confirmpassword', 'Potwierdź nowe hasło') }}
                            {{-- {{ Form::password('confirmpassword', null, ['class' => 'form-control']) }} --}}
                            <input type="password" name="confirmpassword" class="form-control @error('confirmpassword') is-invalid @enderror">
                            @error('confirmpassword')
                              <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                          </div>
          {{ Form::submit('Zapisz', ['class' => 'card-btn']) }}
          {!! Form::close() !!}
      </div>

      <div class="contact-set">
          <h2>Kontakt</h2>
          <h4>Edytuj swoje dane kontaktowe</h4>
          <hr>
          {!! Form::open(['action' => ['UstawieniaController@contact'],
                          'method' => 'PUT']) !!}
                          @csrf
                          <div class="form-group">
                            {{ Form::label('email', 'Nowy adres email') }}
                            {{-- {{ Form::text('email', null, ['class' => 'form-control']) }} --}}
                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                              <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                          </div>
                          <div class="form-group">
                            {{ Form::label('phonenumber', 'Numer telefonu') }}
                            {{-- {{ Form::text('phonenumber', $user->phonenumber, ['class' => 'form-control']) }} --}}
                            <input type="text" name="phonenumber" class="form-control @error('phonenumber') is-invalid @enderror" value="{{ $user->phonenumber }}">
                            @error('phonenumber')
                              <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                            @enderror
                          </div>
          {{ Form::submit('Zmień dane', ['class' => 'card-btn']) }}
          {!! Form::close() !!}
      </div>

      <div class="notifi-set">
          <h2>Otrzymuj powiadomienia email</h2>
          <h4>Między innymi powiadominia zostaną wysłane na twój adres email gdy dostaniesz nową wiadomość</h4>
          <hr>
            {!! Form::open(['action' => ['UstawieniaController@changeNotification'],
                            'method' => 'PUT']) !!}
                @if($user->notifications == true)
                  {{ Form::submit('Wyłącz powiadomienia', ['class' => 'card-btn card-btn-del']) }}
                @else
                  {{ Form::submit('Włącz powiadomienia', ['class' => 'card-btn']) }}
                @endif
            {!! Form::close() !!}
      </div>

      <div class="deactivate-set">
          <h2>Dezaktywuj konto</h2>
          <h4>Możesz wyłączyć swoje konto na tyle ile chcesz. Jeśli wyłączysz konto wszystkie twoje ogoszenia znikną. Gdy ponownie się zalogujesz, konto zostanie włączone ponownie wystawiając ogłoszenia.</h4>
          <hr>
          {!! Form::open(['action' => ['UstawieniaController@deactivate'],
                          'method' => 'PUT']) !!}
          {{ Form::submit('Dezaktywuj konto', ['class' => 'card-btn card-btn-del']) }}
          {!! Form::close() !!}
      </div>
@endsection
