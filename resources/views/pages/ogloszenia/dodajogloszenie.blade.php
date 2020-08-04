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
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
              @error('title')
                  <span class="invalid-feedback" role="alert">
                    {{ $message }}
                  </span>
              @enderror
          </div>
          <div class="form-group">
            {{ Form::label('city', 'Miasto') }}
            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}">
              @error('city')
                  <span class="invalid-feedback" role="alert">
                    {{ $message }}
                  </span>
              @enderror

          </div>
          <div class="form-group">
            {{ Form::label('district', 'Dzielnica') }}
            <input type="text" name="district" class="form-control @error('district') is-invalid @enderror" value="{{ old('district') }}">
              @error('district')
                  <span class="invalid-feedback" role="alert">
                    {{ $message }}
                  </span>
              @enderror
          </div>
          <div class="form-group">
            {{ Form::label('description', 'Opis') }}
            <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
              @error('description')
                  <span class="invalid-feedback" role="alert">
                    {{ $message }}
                  </span>
              @enderror
          </div>
          <div class="form-group">
            {{ Form::label('size', 'Metraż') }}
            <input type="text" name="size" class="form-control @error('size') is-invalid @enderror" value="{{ old('size') }}">
              @error('size')
                  <span class="invalid-feedback" role="alert">
                    {{ $message }}
                  </span>
              @enderror
          </div>

          <div class="form-group">
            {{ Form::label('price', 'Cena') }}
            <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
              @error('price')
                  <span class="invalid-feedback" role="alert">
                    {{ $message }}
                  </span>
              @enderror
          </div>

          <div class="form-group">
            <input type="checkbox" name="to_negotiate" value="to_negotiate" @if(old('to_negotiate')) checked @endif>
            {{ Form::label('to_negotiate', 'Cena do negocjacji') }}
          </div>

          <div class="form-group">
            {{ Form::label('dodatkowy_czynsz', 'Dodatkowy czynsz') }}
            <input type="text" name="dodatkowy_czynsz" class="form-control @error('dodatkowy_czynsz') is-invalid @enderror" value="{{ old('dodatkowy_czynsz') }}">
              @error('dodatkowy_czynsz')
                  <span class="invalid-feedback" role="alert">
                    {{ $message }}
                  </span>
              @enderror
          </div>

          <div class="form-group">
            {{ Form::label('pokoje', 'Pokoje') }}
            <select class="form-control" name="pokoje" value="{{ old('pokoje') }}">
              <option>wybierz</option>
              @php
                for ($i=1; $i <= 5; $i++){
                  echo '<option value="'.$i.'">'.$i.'</option>';
                }
              @endphp
              <option value="wiecejniz5">więcej niż 5</option>
            </select>
          </div>

          <div class="form-group">
            {{ Form::label('pietro', 'Piętro') }}
            <select class="form-control" name="pietro" value="{{ old('pietro') }}">
              <option>wybierz</option>
              <option value="parter">parter</option>
              @php
                for ($i=1; $i <= 10; $i++){
                  echo '<option value="'.$i.'">'.$i.'</option>';
                }
              @endphp
              <option value="wiecejniz10">więcej niż 10</option>
            </select>
          </div>

          <div class="form-group">
            {{ Form::label('stan', 'Stan') }}
            <select class="form-control" name="stan" value="{{ old('stan') }}">
              <option>wybierz</option>
              <option value="do_zamieszkania">do zamieszkania</option>
              <option value="do_wykonczenia">do wykończenia</option>
              <option value="do_remontu">do remontu</option>
            </select>
          </div>

          <div class="form-group">
            {{ Form::label('ogrzewanie', 'Ogrzewanie') }}
            <select class="form-control" name="ogrzewanie" value="{{ old('ogrzewanie') }}">
              <option>wybierz</option>
              <option value="miejskie">miejskie</option>
              <option value="gazowe">gazowe</option>
              <option value="piec_kaflowy">piec kaflowy</option>
              <option value="elektryczne">elektryczne</option>
              <option value="kotłownia">kotłownia</option>
              <option value="inne">inne</option>
            </select>
          </div>


          <div class="form-group">
            {{ Form::label('rok', 'Rok budowy') }}
            <input type="text" name="rok" class="form-control @error('rok') is-invalid @enderror" value="{{ old('rok') }}">
              @error('rok')
                  <span class="invalid-feedback" role="alert">
                    {{ $message }}
                  </span>
              @enderror
          </div>

          <div class="form-group">
            <h4>Wyposażenie</h2>

            <input type="checkbox" name="meble" value="meble" @if(old('meble')) checked @endif>
            {{ Form::label('meble', 'Meble') }}

            <input type="checkbox" name="pralka" value="pralka" @if(old('pralka')) checked @endif>
            {{ Form::label('pralka', 'Pralka') }}

            <input type="checkbox" name="zmywarka" value="zmywarka" @if(old('zmywarka')) checked @endif>
            {{ Form::label('zmywarka', 'Zmywarka') }}

            <input type="checkbox" name="lodowka" value="lodowka" @if(old('lodowka')) checked @endif>
            {{ Form::label('lodowka', 'Lodówka') }}

            <input type="checkbox" name="kuchenka" value="kuchenka" @if(old('kuchenka')) checked @endif>
            {{ Form::label('kuchenka', 'Kuchenka') }}

            <input type="checkbox" name="piekarnik" value="piekarnik" @if(old('piekarnik')) checked @endif>
            {{ Form::label('piekarnik', 'Piekarnik') }}

            <input type="checkbox" name="telewizor" value="telewizor" @if(old('telewizor')) checked @endif>
            {{ Form::label('telewizor', 'Telewizor') }}

          </div>

          <div class="form-group">
            <h4>Dodatkowe informacje</h2>

            <input type="checkbox" name="balkon" value="balkon" @if(old('balkon')) checked @endif>
            {{ Form::label('balkon', 'Balkon') }}

            <input type="checkbox" name="garaz" value="garaz" @if(old('garaz')) checked @endif>
            {{ Form::label('garaz', 'Garaż') }}

            <input type="checkbox" name="miejsce_parkingowe" value="miejsce_parkingowe" @if(old('miejsce_parkingowe')) checked @endif>
            {{ Form::label('miejsce_parkingowe', 'Miejsce parkingowe') }}

            <input type="checkbox" name="piwnica" value="piwnica" @if(old('piwnica')) checked @endif>
            {{ Form::label('piwnica', 'Piwnica') }}

            <input type="checkbox" name="ogrodek" value="ogrodek" @if(old('ogrodek')) checked @endif>
            {{ Form::label('ogrodek', 'Ogródek') }}

            <input type="checkbox" name="klimatyzacja" value="klimatyzacja" @if(old('klimatyzacja')) checked @endif>
            {{ Form::label('klimatyzacja', 'Klimatyzacja') }}

            <input type="checkbox" name="winda" value="winda" @if(old('winda')) checked @endif>
            {{ Form::label('winda', 'Winda') }}

          </div>

          {{--
           --}}

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
