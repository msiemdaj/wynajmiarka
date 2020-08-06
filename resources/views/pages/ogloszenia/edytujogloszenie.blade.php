@extends('layouts/app')

@section('content')
    <div class="container">
      <div class="ogloszenie-heading">
        <h2>Edytuj ogłoszenie</h2>
        <h4>Zmień treść ogłoszenia i dane dotyczące twojego mieszkania. Możesz także usunąć lub dodać zdjęcia.</h4>
      </div>

      {!! Form::open(['action' => ['OgloszeniaController@update', $ogloszenie->id],
                      'method' => 'PUT',
                      'enctype' => 'multipart/form-data',
                      'data-toggle' => 'validator']) !!}
          @csrf
          <div class="form-group">
            <label for="title" class="required">Tytuł ogłoszenia</label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" @if(old('title')) value="{{ old('title') }}"
                                                                                                      @else value="{{ $ogloszenie->title }}" @endif>
              @error('title')
                <span class="invalid-feedback" role="alert">
                      {{ $message }}
                  </span>
              @enderror
          </div>
          <div class="form-group">
            <label for="city" class="required">Miasto</label>
            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" @if(old('city')) value="{{ old('city') }}"
                                                                                                    @else value="{{ $ogloszenie->city }}" @endif>
            @error('city')
              <span class="invalid-feedback" role="alert">
                    {{ $message }}
                </span>
            @enderror
          </div>
          <div class="form-group">
            <label for="district" class="required">Dzielnica</label>
            <input type="text" name="district" class="form-control @error('district') is-invalid @enderror" @if(old('district')) value="{{ old('district') }}"
                                                                                                            @else value="{{ $ogloszenie->district }}" @endif>
              @error('district')
                <span class="invalid-feedback" role="alert">
                      {{ $message }}
                  </span>
              @enderror
          </div>
          <div class="form-group">
            <label for="description" class="required">Opis</label>
            <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">@if(old('description')){{old('description')}}@else{{$ogloszenie->description}}@endif</textarea>
              @error('description')
                <span class="invalid-feedback" role="alert">
                      {{ $message }}
                  </span>
              @enderror
          </div>

          <div class="form-row">
          <div class="col-md-6">
            <div class="form-group">
              <label for="size" class="required">Metraż</label>
              <input type="text" name="size" class="form-control @error('size') is-invalid @enderror" @if(old('size')) value="{{ old('size') }}"
                                                                                                      @else value="{{ $ogloszenie->size }}" @endif>
                @error('size')
                    <span class="invalid-feedback" role="alert">
                      {{ $message }}
                    </span>
                @enderror
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              {{ Form::label('rok', 'Rok budowy') }}
              <input type="text" name="rok" class="form-control @error('rok') is-invalid @enderror" @if(old('rok')) value="{{ old('rok') }}"
                                                                                                    @elseif(isset($ogloszenie->year_of_construction)) value="{{ $ogloszenie->year_of_construction }}" @endif>
                @error('rok')
                    <span class="invalid-feedback" role="alert">
                      {{ $message }}
                    </span>
                @enderror
            </div>
          </div>
        </div>

          <div class="form-group">
            <label for="price" class="required">Cena</label>
            <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ $ogloszenie->price }}">
              @error('price')
                <span class="invalid-feedback" role="alert">
                      {{ $message }}
                  </span>
              @enderror
          </div>

          <div class="form-row">
            <div class="col-md-4">
              <div class="form-group">
                {{ Form::label('price', 'Cena') }}
                <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" @if(old('price')) value="{{ old('price') }}"
                                                                                                          @else value="{{ $ogloszenie->price }}" @endif>
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
                <input type="text" name="dodatkowy_czynsz" class="form-control @error('dodatkowy_czynsz') is-invalid @enderror" @if(old('dodatkowy_czynsz')) value="{{ old('dodatkowy_czynsz') }}"
                                                                                                                                @elseif(isset($ogloszenie->additional_costs)) value="{{ $ogloszenie->additional_costs }}" @endif>
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
                <input type="text" name="kaucja" class="form-control @error('kaucja') is-invalid @enderror" @if(old('kaucja')) value="{{ old('kaucja') }}"
                                                                                                            @elseif(isset($ogloszenie->deposit)) value="{{ $ogloszenie->deposit }}" @endif>
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
            <input type="checkbox" name="to_negotiate" id="to_negotiate" class="custom-control-input" value="to_negotiate" @if(old('to_negotiate') == 'to_negotiate') checked
                                                                                                                           @elseif($ogloszenie->to_negotiate == true) checked @endif>
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
                    <option value="{{$i}}" {{ $ogloszenie->rooms == $i ? 'selected' : '' }}>{{$i}}</option>
                  @endfor
                  <option value="więcej_niż_5" {{ $ogloszenie->rooms == 'więcej_niż_5' ? 'selected' : '' }}>więcej niż 5</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                {{ Form::label('pietro', 'Piętro') }}
                <select class="form-control" name="pietro">
                  <option>wybierz</option>
                  <option value="parter" {{ $ogloszenie->floor == 'parter' ? 'selected' : '' }}>parter</option>
                  @for ($i=1; $i <= 10; $i++)
                    <option value="{{$i}}" {{ $ogloszenie->floor == $i ? 'selected' : '' }}>{{$i}}</option>
                  @endfor
                  <option value="więcej_niż_10" {{ $ogloszenie->floor == 'więcej_niż_10' ? 'selected' : '' }}>więcej niż 10</option>
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
                  <option value="do_zamieszkania" {{ $ogloszenie->condition == 'do_zamieszkania' ? 'selected' : '' }}>do zamieszkania</option>
                  <option value="do_wykończenia" {{ $ogloszenie->condition == 'do_wykończenia' ? 'selected' : '' }}>do wykończenia</option>
                  <option value="do_remontu" {{ $ogloszenie->condition == 'do_remontu' ? 'selected' : '' }}>do remontu</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                {{ Form::label('ogrzewanie', 'Ogrzewanie') }}
                <select class="form-control" name="ogrzewanie">
                  <option>wybierz</option>
                  <option value="miejskie" {{ $ogloszenie->heating == 'miejskie' ? 'selected' : '' }}>miejskie</option>
                  <option value="gazowe" {{ $ogloszenie->heating == 'gazowe' ? 'selected' : '' }}>gazowe</option>
                  <option value="piec_kaflowy" {{ $ogloszenie->heating == 'piec_kaflowy' ? 'selected' : '' }}>piec kaflowy</option>
                  <option value="elektryczne" {{ $ogloszenie->heating == 'elektryczne' ? 'selected' : '' }}>elektryczne</option>
                  <option value="kotłownia" {{ $ogloszenie->heating == 'kotłownia' ? 'selected' : '' }}>kotłownia</option>
                  <option value="inne" {{ $ogloszenie->heating == 'inne' ? 'selected' : '' }}>inne</option>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group noS-Pt">
            <h4>Wyposażenie</h2>

              @if ($ogloszenie->equipment)
                @php
                  $equipment = json_decode($ogloszenie->equipment);
                @endphp
              @endif

              {{--
              @if(is_array(old('equipment')) and in_array('meble', old('equipment'))) checked
              @elseif(isset($ogloszenie->additional_costs)) value="{{ $ogloszenie->additional_costs }}" @endif
               --}}

            <div class="custom-control custom-checkbox custom-control-inline">
              <input type="checkbox" id="meble" name="equipment[]" class="custom-control-input" value="meble" {{ (is_array($equipment) and in_array('meble', $equipment)) ? ' checked' : '' }}>
              <label class="custom-control-label" for="meble">Meble</label>
            </div>

            <div class="custom-control custom-checkbox custom-control-inline">
              <input type="checkbox" id="pralka" name="equipment[]" class="custom-control-input" value="pralka" {{ (is_array($equipment) and in_array('pralka', $equipment)) ? ' checked' : '' }}>
              <label class="custom-control-label" for="pralka">Pralka</label>
            </div>

            <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="zmywarka" name="equipment[]" class="custom-control-input" value="zmywarka" {{ (is_array($equipment) and in_array('zmywarka', $equipment)) ? ' checked' : '' }}>
            <label class="custom-control-label" for="zmywarka">Zmywarka</label>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="lodowka" name="equipment[]" class="custom-control-input" value="lodówka" {{ (is_array($equipment) and in_array('lodówka', $equipment)) ? ' checked' : '' }}>
            <label class="custom-control-label" for="lodowka">Lodówka</label>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="kuchenka" name="equipment[]" class="custom-control-input" value="kuchenka" {{ (is_array($equipment) and in_array('kuchenka', $equipment)) ? ' checked' : '' }}>
            <label class="custom-control-label" for="kuchenka">Kuchenka</label>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="piekarnik" name="equipment[]" class="custom-control-input" value="piekarnik" {{ (is_array($equipment) and in_array('piekarnik', $equipment)) ? ' checked' : '' }}>
            <label class="custom-control-label" for="piekarnik">Piekarnik</label>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="telewizor" name="equipment[]" class="custom-control-input" value="telewizor" {{ (is_array($equipment) and in_array('telewizor', $equipment)) ? ' checked' : '' }}>
            <label class="custom-control-label" for="telewizor">Telewizor</label>
          </div>
          </div>

          <div class="form-group noS-Pt">
            <h4>Dodatkowe informacje</h2>

              @if ($ogloszenie->additional_info)
                @php
                  $additional_info = json_decode($ogloszenie->additional_info);
                @endphp
              @endif

              <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="balkon" name="additional_info[]" class="custom-control-input" value="balkon" {{ (is_array($additional_info) and in_array('balkon', $additional_info)) ? ' checked' : '' }}>
            <label class="custom-control-label" for="balkon">Balkon</label>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="garaz" name="additional_info[]" class="custom-control-input" value="garaż" {{ (is_array($additional_info) and in_array('garaż', $additional_info)) ? ' checked' : '' }}>
            <label class="custom-control-label" for="garaz">Garaż</label>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="miejsce_parkingowe" name="additional_info[]" class="custom-control-input" value="miejsce_parkingowe" {{ (is_array($additional_info) and in_array('miejsce_parkingowe', $additional_info)) ? ' checked' : '' }}>
            <label class="custom-control-label" for="miejsce_parkingowe">Miejsce parkingowe</label>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="piwnica" name="additional_info[]" class="custom-control-input" value="piwnica" {{ (is_array($additional_info) and in_array('piwnica', $additional_info)) ? ' checked' : '' }}>
            <label class="custom-control-label" for="piwnica">Piwnica</label>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="ogrodek" name="additional_info[]" class="custom-control-input" value="ogródek" {{ (is_array($additional_info) and in_array('ogródek', $additional_info)) ? ' checked' : '' }}>
            <label class="custom-control-label" for="ogrodek">Ogródek</label>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="klimatyzacja" name="additional_info[]" class="custom-control-input" value="klimatyzacja" {{ (is_array($additional_info) and in_array('klimatyzacja', $additional_info)) ? ' checked' : '' }}>
            <label class="custom-control-label" for="klimatyzacja">Klimatyzacja</label>
          </div>
          <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="winda" name="additional_info[]" class="custom-control-input" value="winda" {{ (is_array($additional_info) and in_array('winda', $additional_info)) ? ' checked' : '' }}>
            <label class="custom-control-label" for="winda">Winda</label>
          </div>
          </div>


          {{--
           --}}

           <h4 class="required">Zdjęcia</h4>

          <script type="text/jscript">
          $(function () {
          @if($ogloszenie->image)
            @php
              $idnum = 1;
              $imageArray = json_decode($ogloszenie->image);
            @endphp

            var preloaded = [];
            var i = 1;

            @foreach ($imageArray as $imageName)
            preloaded.push({id: i, src: '{{asset('images/'.$ogloszenie->id.'/'.$imageName) }}'},);
            i++;
            @endforeach
          @endif

                $('.input-images-2').imageUploader({
                    preloaded: preloaded,
                    imagesInputName: 'images',
                    preloadedInputName: 'old',
                });
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

          {{ Form::submit('Edytuj ogłoszenie', ['class' => 'ogloszenie-confirm-button']) }}
      {!! Form::close() !!}

    </div>
@endsection
