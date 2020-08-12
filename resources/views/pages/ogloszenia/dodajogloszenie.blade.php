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
            {{-- {{ Form::label('title', 'Tytuł ogłoszenia') }} --}}
            <label for="title" class="required">Tytuł ogłoszenia</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
              @error('title')
                  <span class="invalid-feedback" role="alert">
                    {{ $message }}
                  </span>
              @enderror
          </div>


    <div class="form-row">
    <div class="col-md-4">
      <div class="form-group">
        <label for="city" class="required">Miasto</label>
        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}">
          @error('city')
              <span class="invalid-feedback" role="alert">
                {{ $message }}
              </span>
          @enderror
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="district">Dzielnica</label>
        <input type="text" name="district" class="form-control @error('district') is-invalid @enderror" value="{{ old('district') }}">
          @error('district')
              <span class="invalid-feedback" role="alert">
                {{ $message }}
              </span>
          @enderror
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group">
        <label for="street">Ulica / osiedle</label>
        <input type="text" name="street" class="form-control @error('street') is-invalid @enderror" value="{{ old('street') }}">
          @error('street')
              <span class="invalid-feedback" role="alert">
                {{ $message }}
              </span>
          @enderror
      </div>
    </div>
    </div>

          <div class="form-group">
            <label for="description" class="required">Opis</label> <i class="info material-icons" data-toggle="tooltip" data-placement="top" title="Dodaj szczegółowy opis swojego ogłoszenia. Dobrze opisane oferty dostają więcej odpowiedzi. Wykorzystaj limit 5000 znaków. ">help</i>
            <textarea name="description" id="description" rows="5" maxlength="5000" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
              <div class="description-feedback">
                @error('description')
                    <span class="invalid-feedback" role="alert">
                      {{ $message }}
                    </span>
                @enderror
                <div id="textarea_feedback"></div>
              </div>

          </div>


        <script type="text/javascript">
        $(document).ready(function() {
        var length = $('#description').val().length;

          $('#textarea_feedback').html(length+'/5000');
          $('#description').keyup(function() {
              length = $('#description').val().length;

              $('#textarea_feedback').html(length + '/5000');
          });
        });
        </script>

          <div class="form-row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="size" class="required">Metraż</label>
              <div class="suffix">m<sup>2</sup></div>
              <input type="text" name="size" class="form-control with-suffix @error('size') is-invalid @enderror" value="{{ old('size') }}">

                @error('size')
                    <span class="invalid-feedback" role="alert">
                      {{ $message }}
                    </span>
                @enderror
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              {{ Form::label('datepicker', 'Rok budowy') }}
              <input type="text" name="rok" id="datepicker" autocomplete="off" class="form-control @error('rok') is-invalid @enderror" value="{{ old('rok') }}">
                @error('rok')
                    <span class="invalid-feedback" role="alert">
                      {{ $message }}
                    </span>
                @enderror
            </div>
          </div>
        </div>

          <div class="form-row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="price" class="required">Cena</label>
                <div class="suffix">zł</div>
                <input id="price" type="text" name="price" class="form-control with-suffix @error('price') is-invalid @enderror" value="{{ old('price') }}">
                  @error('price')
                      <span class="invalid-feedback" role="alert">
                        {{ $message }}
                      </span>
                  @enderror
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                {{ Form::label('dodatkowy_czynsz', 'Dodatkowy czynsz') }}
                <div class="suffix">zł</div>
                <input type="text" name="dodatkowy_czynsz" class="form-control with-suffix @error('dodatkowy_czynsz') is-invalid @enderror" value="{{ old('dodatkowy_czynsz') }}">
                  @error('dodatkowy_czynsz')
                      <span class="invalid-feedback" role="alert">
                        {{ $message }}
                      </span>
                  @enderror
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                {{ Form::label('kaucja', 'Kaucja') }}
                <div class="suffix">zł</div>
                <input type="text" name="kaucja" class="form-control with-suffix @error('kaucja') is-invalid @enderror" value="{{ old('kaucja') }}">
                  @error('kaucja')
                    <span class="invalid-feedback" role="alert">
                      {{ $message }}
                    </span>
                  @enderror
              </div>
            </div>
          </div>

          <div class="form-group noS-Pt">
            <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" name="to_negotiate" id="to_negotiate" class="custom-control-input" value="to_negotiate" @if(old('to_negotiate')) checked @endif>
              <label class="custom-control-label" for="to_negotiate">Cena do negocjacji</label>
            </div>
          </div>

          <div class="form-row">
            <div class="col-md-6">
              <div class="form-group">
                {{ Form::label('pokoje', 'Pokoje') }}
                <select class="form-control" name="pokoje">
                  <option>wybierz</option>
                  @for ($i=1; $i <= 5; $i++)
                    <option value="{{$i}}" {{ old('pokoje') == $i ? 'selected' : '' }}>{{$i}}</option>
                  @endfor
                  <option value="więcej_niż_5" {{ old('pokoje') == 'więcej_niż_5' ? 'selected' : '' }}>więcej niż 5</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                {{ Form::label('pietro', 'Piętro') }}
                <select class="form-control" name="pietro">
                  <option>wybierz</option>
                  <option value="parter" {{ old('pietro') == 'parter' ? 'selected' : '' }}>parter</option>
                  @for ($i=1; $i <= 10; $i++)
                    <option value="{{$i}}" {{ old('pietro') == $i ? 'selected' : '' }}>{{$i}}</option>
                  @endfor
                  <option value="więcej_niż_10" {{ old('pietro') == 'więcej_niż_10' ? 'selected' : '' }}>więcej niż 10</option>
                </select>
              </div>
            </div>
          </div>

          <div class="form-row">
            <div class="col-md-6">
              <div class="form-group">
                {{ Form::label('stan', 'Stan') }}
                <select class="form-control" name="stan">
                  <option>wybierz</option>
                  <option value="do_zamieszkania" {{ old('stan') == 'do_zamieszkania' ? 'selected' : '' }}>do zamieszkania</option>
                  <option value="do_wykończenia" {{ old('stan') == 'do_wykończenia' ? 'selected' : '' }}>do wykończenia</option>
                  <option value="do_remontu" {{ old('stan') == 'do_remontu' ? 'selected' : '' }}>do remontu</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                {{ Form::label('ogrzewanie', 'Ogrzewanie') }}
                <select class="form-control" name="ogrzewanie">
                  <option>wybierz</option>
                  <option value="miejskie" {{ old('ogrzewanie') == 'miejskie' ? 'selected' : '' }}>miejskie</option>
                  <option value="gazowe" {{ old('ogrzewanie') == 'gazowe' ? 'selected' : '' }}>gazowe</option>
                  <option value="piec_kaflowy" {{ old('ogrzewanie') == 'piec_kaflowy' ? 'selected' : '' }}>piec kaflowy</option>
                  <option value="elektryczne" {{ old('ogrzewanie') == 'elektryczne' ? 'selected' : '' }}>elektryczne</option>
                  <option value="kotłownia" {{ old('ogrzewanie') == 'kotłownia' ? 'selected' : '' }}>kotłownia</option>
                  <option value="inne" {{ old('ogrzewanie') == 'inne' ? 'selected' : '' }}>inne</option>
                </select>
              </div>
            </div>
          </div>


          <div class="form-group noS-Pt">
            <h4>Wyposażenie</h2>

            <div class="custom-control custom-checkbox custom-control-inline">
              <input type="checkbox" id="meble" name="equipment[]" class="custom-control-input" value="meble" {{ (is_array(old('equipment')) and in_array('meble', old('equipment'))) ? ' checked' : '' }}>
              <label class="custom-control-label" for="meble">Meble</label>
            </div>

            <div class="custom-control custom-checkbox custom-control-inline">
              <input type="checkbox" id="pralka" name="equipment[]" class="custom-control-input" value="pralka" {{ (is_array(old('equipment')) and in_array('pralka', old('equipment'))) ? ' checked' : '' }}>
              <label class="custom-control-label" for="pralka">Pralka</label>
            </div>

            <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="zmywarka" name="equipment[]" class="custom-control-input" value="zmywarka" {{ (is_array(old('equipment')) and in_array('zmywarka', old('equipment'))) ? ' checked' : '' }}>
            <label class="custom-control-label" for="zmywarka">Zmywarka</label>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="lodowka" name="equipment[]" class="custom-control-input" value="lodówka" {{ (is_array(old('equipment')) and in_array('lodówka', old('equipment'))) ? ' checked' : '' }}>
            <label class="custom-control-label" for="lodowka">Lodówka</label>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="kuchenka" name="equipment[]" class="custom-control-input" value="kuchenka" {{ (is_array(old('equipment')) and in_array('kuchenka', old('equipment'))) ? ' checked' : '' }}>
            <label class="custom-control-label" for="kuchenka">Kuchenka</label>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="piekarnik" name="equipment[]" class="custom-control-input" value="piekarnik" {{ (is_array(old('equipment')) and in_array('piekarnik', old('equipment'))) ? ' checked' : '' }}>
            <label class="custom-control-label" for="piekarnik">Piekarnik</label>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="telewizor" name="equipment[]" class="custom-control-input" value="telewizor" {{ (is_array(old('equipment')) and in_array('telewizor', old('equipment'))) ? ' checked' : '' }}>
            <label class="custom-control-label" for="telewizor">Telewizor</label>
          </div>
          </div>

          <div class="form-group noS-Pt">
            <h4>Dodatkowe informacje</h2>

              <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="balkon" name="additional_info[]" class="custom-control-input" value="balkon" {{ (is_array(old('additional_info')) and in_array('balkon', old('additional_info'))) ? ' checked' : '' }}>
            <label class="custom-control-label" for="balkon">Balkon</label>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="garaz" name="additional_info[]" class="custom-control-input" value="garaż" {{ (is_array(old('additional_info')) and in_array('garaż', old('additional_info'))) ? ' checked' : '' }}>
            <label class="custom-control-label" for="garaz">Garaż</label>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="miejsce_parkingowe" name="additional_info[]" class="custom-control-input" value="miejsce_parkingowe" {{ (is_array(old('additional_info')) and in_array('miejsce_parkingowe', old('additional_info'))) ? ' checked' : '' }}>
            <label class="custom-control-label" for="miejsce_parkingowe">Miejsce parkingowe</label>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="piwnica" name="additional_info[]" class="custom-control-input" value="piwnica" {{ (is_array(old('additional_info')) and in_array('piwnica', old('additional_info'))) ? ' checked' : '' }}>
            <label class="custom-control-label" for="piwnica">Piwnica</label>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="ogrodek" name="additional_info[]" class="custom-control-input" value="ogródek" {{ (is_array(old('additional_info')) and in_array('ogródek', old('additional_info'))) ? ' checked' : '' }}>
            <label class="custom-control-label" for="ogrodek">Ogródek</label>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="klimatyzacja" name="additional_info[]" class="custom-control-input" value="klimatyzacja" {{ (is_array(old('additional_info')) and in_array('klimatyzacja', old('additional_info'))) ? ' checked' : '' }}>
            <label class="custom-control-label" for="klimatyzacja">Klimatyzacja</label>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="winda" name="additional_info[]" class="custom-control-input" value="winda" {{ (is_array(old('additional_info')) and in_array('winda', old('additional_info'))) ? ' checked' : '' }}>
            <label class="custom-control-label" for="winda">Winda</label>
          </div>
          </div>

        <div class="zdjecia-header">
          <h4 class="required h4in">Zdjęcia</h4>
          <i class="info material-icons" data-toggle="tooltip" data-placement="top" title="Prześlij do 16 zdjęć o maksymalnej wielkości 5MB">help</i>
        </div>
          {{--
           --}}

           <script type="text/javascript">
             $(document).ready(function() {
                  $('.with-suffix').each(function() {
                    if($(this).hasClass('is-invalid')){
                      var parent = $(this).parent();
                      var suffix = parent.find('.suffix');
                      suffix.hide();
                    }
                });
             });
           </script>

           <script type="text/javascript">
           $("#datepicker").datepicker( {
             format: " yyyy",
             viewMode: "years",
             minViewMode: "years"
           });
           </script>

           <script type="text/javascript">
           $(function () {
             $('[data-toggle="tooltip"]').tooltip({
               trigger : 'hover'
               });
             });
           </script>

    <script type="application/javascript">
      $(function () {
        $('.input-images-2').imageUploader();
        $('input[name="images[]"]').addClass("@error('images.*') is-invalid @enderror @error('images') error-img @enderror");
      });
    </script>

    <div class="form-group">
      <div class="input-images-2">
          <script type="application/javascript">
            $(function (){
              $('.image-uploader').addClass("@error('images.*') error-img @enderror @error('images') error-img @enderror");
            });
          </script>
      </div>
      @error('images.*')
        <span class="image-error-span" role="alert">
          {{ $message }}
        </span>
      @enderror
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
