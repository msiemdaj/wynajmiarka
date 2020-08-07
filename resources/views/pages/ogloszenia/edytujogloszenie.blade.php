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
                      'data-toggle' => 'validator',
                      'class' => 'edit-ogloszenie-form']) !!}
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

          <div class="form-row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="price" class="required">Cena</label>
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
                @php
                  $flag=0;
                @endphp
                {{ Form::label('pokoje', 'Pokoje') }}
                <select class="form-control" name="pokoje">
                  @foreach ($roomsArray as $room)
                    <option @if($room != 'wybierz') value="{{$room}}" @endif
                                                     @if($flag==0)
                                                     @if($ogloszenie->rooms == $room) selected @endif
                                                     @if(old('pokoje') == $room) selected @php $flag = 1; @endphp @endif @endif>{{str_replace("_", " ", $room)}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                @php
                  $flag=0;
                @endphp
                {{ Form::label('pietro', 'Piętro') }}
                <select class="form-control" name="pietro">
                  @foreach ($floorArray as $floor)
                    <option @if($floor != 'wybierz') value="{{$floor}}" @endif
                                                     @if($flag==0)
                                                     @if($ogloszenie->floor == $floor) selected @endif
                                                     @if(old('pietro') == $floor) selected @php $flag = 1; @endphp @endif @endif>{{str_replace("_", " ", $floor)}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>



          <div class="form-row">
            <div class="col-md-6">
              <div class="form-group">
                @php
                  $flag=0;
                @endphp
                {{ Form::label('stan', 'Stan') }}
                <select class="form-control" name="stan">
                  @foreach ($stanArray as $stanItem)
                    <option @if($stanItem != 'wybierz') value="{{$stanItem}}" @endif
                                                     @if($flag==0)
                                                     @if($ogloszenie->condition == $stanItem) selected @endif
                                                     @if(old('stan') == $stanItem) selected @php $flag = 1; @endphp @endif @endif>{{str_replace("_", " ", $stanItem)}}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                @php
                  $flag=0;
                @endphp
                {{ Form::label('ogrzewanie', 'Ogrzewanie') }}
                <select class="form-control" name="ogrzewanie">
                  @foreach ($heatingArray as $heating)
                    <option @if($heating != 'wybierz') value="{{$heating}}" @endif
                                                     @if($flag==0)
                                                     @if($ogloszenie->heating == $heating) selected @endif
                                                     @if(old('ogrzewanie') == $heating) selected @php $flag = 1; @endphp @endif @endif>{{str_replace("_", " ", $heating)}}</option>
                  @endforeach
                  </select>
              </div>
            </div>
          </div>


          <div class="form-group noS-Pt">
            <h4>Wyposażenie</h2>
              @if(!empty($ogloszenie->equipment))
                @php
                  $equipment = json_decode($ogloszenie->equipment);
                @endphp
              @endif

              @foreach ($equipmentArray as $equipmentItem)
                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="{{$equipmentItem}}" name="equipment[]" class="custom-control-input" value="{{$equipmentItem}}"
                        @if(isset($equipment))
                        @if(is_array($equipment) and in_array($equipmentItem, $equipment) and is_array(old('equipment')) and in_array($equipmentItem, old('equipment')) == false)
                        @elseif(is_array($equipment) and in_array($equipmentItem, $equipment) and is_array(old('equipment')) and in_array($equipmentItem, old('equipment')) == true) checked
                        @elseif(is_array($equipment) and in_array($equipmentItem, $equipment)) checked @endif @endif
                        @if(is_array(old('equipment')) and in_array($equipmentItem, old('equipment'))) checked @endif>
                  <label class="custom-control-label" for="{{$equipmentItem}}">{{str_replace("_", " ", $equipmentItem)}}</label>
                </div>
              @endforeach
          </div>

          <div class="form-group noS-Pt">
            <h4>Dodatkowe informacje</h2>

              @if(!empty($ogloszenie->additional_info))
                @php
                  $additional_info = json_decode($ogloszenie->additional_info);
                @endphp
              @endif

              @foreach ($additional_infoArray as $additional_infoItem)
                <div class="custom-control custom-checkbox custom-control-inline">
                  <input type="checkbox" id="{{$additional_infoItem}}" name="additional_info[]" class="custom-control-input" value="{{$additional_infoItem}}"
                        @if(isset($additional_info))
                        @if(is_array($additional_info) and in_array($additional_infoItem, $additional_info) and is_array(old('additional_info')) and in_array($additional_infoItem, old('additional_info')) == false)
                        @elseif(is_array($additional_info) and in_array($additional_infoItem, $additional_info) and is_array(old('additional_info')) and in_array($additional_infoItem, old('additional_info')) == true) checked
                        @elseif(is_array($additional_info) and in_array($additional_infoItem, $additional_info)) checked @endif @endif
                        @if(is_array(old('additional_info')) and in_array($additional_infoItem, old('additional_info'))) checked @endif>
                  <label class="custom-control-label" for="{{$additional_infoItem}}">{{str_replace("_", " ", $additional_infoItem)}}</label>
                </div>
              @endforeach
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

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection
