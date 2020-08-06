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
            {{ Form::label('title', 'Tytuł ogłoszenia') }}
            {{-- {{ Form::text('title', $ogloszenie->title, ['class' => 'form-control']) }} --}}
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" @if(old('title')) value="{{ old('title') }}"
                                                                                                      @else value="{{ $ogloszenie->title }}" @endif>
              @error('title')
                <span class="invalid-feedback" role="alert">
                      {{ $message }}
                  </span>
              @enderror
          </div>
          <div class="form-group">
            {{ Form::label('city', 'Miasto') }}
            {{-- {{ Form::text('city', $ogloszenie->city, ['class' => 'form-control']) }} --}}
            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" @if(old('city')) value="{{ old('city') }}"
                                                                                                    @else value="{{ $ogloszenie->city }}" @endif>
            @error('city')
              <span class="invalid-feedback" role="alert">
                    {{ $message }}
                </span>
            @enderror
          </div>
          <div class="form-group">
            {{ Form::label('district', 'Dzielnica') }}
            {{-- {{ Form::text('district', $ogloszenie->district, ['class' => 'form-control']) }} --}}
            <input type="text" name="district" class="form-control @error('district') is-invalid @enderror" @if(old('district')) value="{{ old('district') }}"
                                                                                                            @else value="{{ $ogloszenie->district }}" @endif>
              @error('district')
                <span class="invalid-feedback" role="alert">
                      {{ $message }}
                  </span>
              @enderror
          </div>
          <div class="form-group">
            {{ Form::label('description', 'Opis') }}
            {{-- {{ Form::textarea('description', $ogloszenie->description, ['class' => 'form-control']) }} --}}
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
              {{ Form::label('size', 'Metraż') }}
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
            {{ Form::label('price', 'Cena') }}
            {{-- {{ Form::text('price', $ogloszenie->price, ['class' => 'form-control']) }} --}}
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
                                                                                                            @elseif(isset($ogloszenie->year_of_construction)) value="{{ $ogloszenie->year_of_construction }}" @endif>
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
            <input type="checkbox" name="to_negotiate" id="to_negotiate" class="custom-control-input" value="to_negotiate" @if($ogloszenie->to_negotiate == true) checked @endif
                                                                                                                           @if(old('to_negotiate')) checked @endif>
              <label class="custom-control-label" for="to_negotiate">Cena do negocjacji</label>
            </div>
          </div>


          {{--
           --}}

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
