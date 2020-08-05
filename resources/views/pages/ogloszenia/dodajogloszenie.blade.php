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
            <select class="form-control" name="pokoje">
              <option>wybierz</option>
              @for ($i=1; $i <= 5; $i++)
                <option value="{{$i}}" {{ old('pokoje') == $i ? 'selected' : '' }}>{{$i}}</option>
              @endfor
              <option value="wiecej_niz_5" {{ old('pokoje') == 'wiecej_niz_5' ? 'selected' : '' }}>więcej niż 5</option>
            </select>
          </div>
          <div class="form-group">
            {{ Form::label('pietro', 'Piętro') }}
            <select class="form-control" name="pietro">
              <option>wybierz</option>
              <option value="parter" {{ old('pietro') == 'parter' ? 'selected' : '' }}>parter</option>
              @for ($i=1; $i <= 10; $i++)
                <option value="{{$i}}" {{ old('pietro') == $i ? 'selected' : '' }}>{{$i}}</option>
              @endfor
              <option value="wiecej_niz_10" {{ old('pietro') == 'wiecej_niz_10' ? 'selected' : '' }}>więcej niż 10</option>
            </select>
          </div>

          <div class="form-group">
            {{ Form::label('stan', 'Stan') }}
            <select class="form-control" name="stan">
              <option>wybierz</option>
              <option value="do_zamieszkania" {{ old('stan') == 'do_zamieszkania' ? 'selected' : '' }}>do zamieszkania</option>
              <option value="do_wykonczenia" {{ old('stan') == 'do_wykonczenia' ? 'selected' : '' }}>do wykończenia</option>
              <option value="do_remontu" {{ old('stan') == 'do_remontu' ? 'selected' : '' }}>do remontu</option>
            </select>
          </div>

          <div class="form-group">
            {{ Form::label('ogrzewanie', 'Ogrzewanie') }}
            <select class="form-control" name="ogrzewanie">
              <option>wybierz</option>
              <option value="miejskie" {{ old('ogrzewanie') == 'miejskie' ? 'selected' : '' }}>miejskie</option>
              <option value="gazowe" {{ old('ogrzewanie') == 'gazowe' ? 'selected' : '' }}>gazowe</option>
              <option value="piec_kaflowy" {{ old('ogrzewanie') == 'piec_kaflowy' ? 'selected' : '' }}>piec kaflowy</option>
              <option value="elektryczne" {{ old('ogrzewanie') == 'elektryczne' ? 'selected' : '' }}>elektryczne</option>
              <option value="kotlownia" {{ old('ogrzewanie') == 'kotlownia' ? 'selected' : '' }}>kotłownia</option>
              <option value="inne" {{ old('ogrzewanie') == 'inne' ? 'selected' : '' }}>inne</option>
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

            <input type="checkbox" name="equipment[]" value="meble" {{ (is_array(old('equipment')) and in_array('meble', old('equipment'))) ? ' checked' : '' }}>
            {{ Form::label('meble', 'Meble') }}

            <input type="checkbox" name="equipment[]" value="pralka" {{ (is_array(old('equipment')) and in_array('pralka', old('equipment'))) ? ' checked' : '' }}>
            {{ Form::label('pralka', 'Pralka') }}

            <input type="checkbox" name="equipment[]" value="zmywarka" {{ (is_array(old('equipment')) and in_array('zmywarka', old('equipment'))) ? ' checked' : '' }}>
            {{ Form::label('zmywarka', 'Zmywarka') }}

            <input type="checkbox" name="equipment[]" value="lodówka" {{ (is_array(old('equipment')) and in_array('lodówka', old('equipment'))) ? ' checked' : '' }}>
            {{ Form::label('lodowka', 'Lodówka') }}

            <input type="checkbox" name="equipment[]" value="kuchenka" {{ (is_array(old('equipment')) and in_array('kuchenka', old('equipment'))) ? ' checked' : '' }}>
            {{ Form::label('kuchenka', 'Kuchenka') }}

            <input type="checkbox" name="equipment[]" value="piekarnik" {{ (is_array(old('equipment')) and in_array('piekarnik', old('equipment'))) ? ' checked' : '' }}>
            {{ Form::label('piekarnik', 'Piekarnik') }}

            <input type="checkbox" name="equipment[]" value="telewizor" {{ (is_array(old('equipment')) and in_array('telewizor', old('equipment'))) ? ' checked' : '' }}>
            {{ Form::label('telewizor', 'Telewizor') }}

          </div>

          <div class="form-group">
            <h4>Dodatkowe informacje</h2>

            <input type="checkbox" name="additional_info[]" value="balkon" {{ (is_array(old('additional_info')) and in_array('balkon', old('additional_info'))) ? ' checked' : '' }}>
            {{ Form::label('balkon', 'Balkon') }}

            <input type="checkbox" name="additional_info[]" value="garaż" {{ (is_array(old('additional_info')) and in_array('garaż', old('additional_info'))) ? ' checked' : '' }}>
            {{ Form::label('garaz', 'Garaż') }}

            <input type="checkbox" name="additional_info[]" value="miejsce parkingowe" {{ (is_array(old('additional_info')) and in_array('miejsce parkingowe', old('additional_info'))) ? ' checked' : '' }}>
            {{ Form::label('miejsce_parkingowe', 'Miejsce parkingowe') }}

            <input type="checkbox" name="additional_info[]" value="piwnica" {{ (is_array(old('additional_info')) and in_array('piwnica', old('additional_info'))) ? ' checked' : '' }}>
            {{ Form::label('piwnica', 'Piwnica') }}

            <input type="checkbox" name="additional_info[]" value="ogródek" {{ (is_array(old('additional_info')) and in_array('ogródek', old('additional_info'))) ? ' checked' : '' }}>
            {{ Form::label('ogrodek', 'Ogródek') }}

            <input type="checkbox" name="additional_info[]" value="klimatyzacja" {{ (is_array(old('additional_info')) and in_array('klimatyzacja', old('additional_info'))) ? ' checked' : '' }}>
            {{ Form::label('klimatyzacja', 'Klimatyzacja') }}

            <input type="checkbox" name="additional_info[]" value="winda" {{ (is_array(old('additional_info')) and in_array('winda', old('additional_info'))) ? ' checked' : '' }}>
            {{ Form::label('winda', 'Winda') }}
          </div>

          {{--
           --}}

           {{-- <div>
<label for="features">Product Features</label><br/>
<label class="checkbox-inline"><input type="checkbox" name="features[]" value="Camera" {{ (is_array(old('features')) and in_array('Camera', old('features'))) ? ' checked' : '' }}/>Camera</label>
<label class="checkbox-inline"><input type="checkbox" name="features[]" value="FrontCamera" {{ (is_array(old('features')) and in_array("FrontCamera", old('features'))) ? ' checked' : '' }}/>Front Camera</label>
<label class="checkbox-inline"><input type="checkbox" name="features[]" value="FingerPrint" {{ (is_array(old('features')) and in_array('FingerPrint', old('features'))) ? ' checked' : '' }}/>Finger print sensor</label>
<label class="checkbox-inline"><input type="checkbox" name="features[]" value="DualSim" {{ (is_array(old('features')) and in_array('DualSim', old('features'))) ? ' checked' : '' }}/>Dual sim</label>
</div> --}}

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
