@extends('layouts/app')

@section('content')
    <div class="container">
      <div class="ogloszenie-heading">
        <h2>Dodaj nowe ogłoszenie</h2>
        <h4>Wypełnij wszystkie pola formularza, aby dodać ogłoszenie na tablice.</h4>
      </div>

      {!! Form::open(['action' => 'OgloszeniaController@store',
                      'method' => 'POST',
                      'enctype' => 'multipart/form-data',
                      'data-toggle' => 'validator',
                      'class' => 'dodaj-ogloszenie-form']) !!}
                      @csrf
          <div class="form-group">
            {{ Form::label('title', 'Tytuł ogłoszenia') }}
            {{-- {{ Form::text('title', null, ["class" => 'form-control']) }} --}}
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
              @error('title')
                  <span class="invalid-feedback" role="alert">
                    {{ $message }}
                  </span>
              @enderror
          </div>
          <div class="form-group">
            {{ Form::label('city', 'Miasto') }}
            {{-- {{ Form::text('city', null, ['class' => 'form-control']) }} --}}
            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}">
              @error('city')
                  <span class="invalid-feedback" role="alert">
                    {{ $message }}
                  </span>
              @enderror

          </div>
          <div class="form-group">
            {{ Form::label('district', 'Dzielnica') }}
            {{-- {{ Form::text('district', null, ['class' => 'form-control']) }} --}}
            <input type="text" name="district" class="form-control @error('district') is-invalid @enderror" value="{{ old('district') }}">
              @error('district')
                  <span class="invalid-feedback" role="alert">
                    {{ $message }}
                  </span>
              @enderror
          </div>
          <div class="form-group">
            {{ Form::label('description', 'Opis') }}
            {{-- {{ Form::textarea('description', null, ['class' => 'form-control']) }} --}}
            <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
              @error('description')
                  <span class="invalid-feedback" role="alert">
                    {{ $message }}
                  </span>
              @enderror
          </div>
          <div class="form-group">
            {{ Form::label('size', 'Metraż') }}
            {{-- {{ Form::text('size', null, ['class' => 'form-control']) }} --}}
            <input type="text" name="size" class="form-control @error('size') is-invalid @enderror" value="{{ old('size') }}">
              @error('size')
                  <span class="invalid-feedback" role="alert">
                    {{ $message }}
                  </span>
              @enderror
          </div>
          <div class="form-group">
            {{ Form::label('price', 'Cena') }}
            {{-- {{ Form::text('price', null, ['class' => 'form-control']) }} --}}
            <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
              @error('price')
                  <span class="invalid-feedback" role="alert">
                    {{ $message }}
                  </span>
              @enderror
          </div>

          <div class="form-group">
            {{ Form::label('to_negotiate', 'Cena do negocjacji') }}
            {{-- {{ Form::text('price', null, ['class' => 'form-control']) }} --}}
            <input type="checkbox" name="to_negotiate" value="to_negotiate" @if(old('to_negotiate')) checked @endif>
          </div>

    <script type="application/javascript">
      $(function () {
        $('.input-images-2').imageUploader();
        $('input[name="images[]"]').addClass("@error('images') is-invalid @enderror");
      });
    </script>

    <div class="form-group">
      <div class="input-images-2">
          <script type="application/javascript">
            $(function (){
              $('.image-uploader').addClass("@error('images') error-img @enderror");
            });
          </script>
      </div>
      @error('images')
        <span class="image-error-span" role="alert">
          {{ $message }}
        </span>
      @enderror
    </div>
          {{ Form::submit('Dodaj ogłoszenie', ['class' => 'ogloszenie-confirm-button']) }}
      {!! Form::close() !!}

      <script type="application/javascript">
      $(function(){
        $('.ogloszenie-confirm-button').click(function(){
            $($(this)).prop('disabled', true);
            $(this.form).submit()
        });
      });
      </script>
    </div>
@endsection
