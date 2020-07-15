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
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ $ogloszenie->title }}">
              @error('title')
                <span class="invalid-feedback" role="alert">
                      {{ $message }}
                  </span>
              @enderror
          </div>
          <div class="form-group">
            {{ Form::label('city', 'Miasto') }}
            {{-- {{ Form::text('city', $ogloszenie->city, ['class' => 'form-control']) }} --}}
            <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ $ogloszenie->city }}">
            @error('city')
              <span class="invalid-feedback" role="alert">
                    {{ $message }}
                </span>
            @enderror
          </div>
          <div class="form-group">
            {{ Form::label('district', 'Dzielnica') }}
            {{-- {{ Form::text('district', $ogloszenie->district, ['class' => 'form-control']) }} --}}
            <input type="text" name="district" class="form-control @error('district') is-invalid @enderror" value="{{ $ogloszenie->district }}">
              @error('district')
                <span class="invalid-feedback" role="alert">
                      {{ $message }}
                  </span>
              @enderror
          </div>
          <div class="form-group">
            {{ Form::label('description', 'Opis') }}
            {{-- {{ Form::textarea('description', $ogloszenie->description, ['class' => 'form-control']) }} --}}
            <textarea name="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ $ogloszenie->description }}
            </textarea>
              @error('description')
                <span class="invalid-feedback" role="alert">
                      {{ $message }}
                  </span>
              @enderror
          </div>
          <div class="form-group">
            {{ Form::label('size', 'Metraż') }}
            {{-- {{ Form::text('size', $ogloszenie->size, ['class' => 'form-control']) }} --}}
            <input type="text" name="size" class="form-control @error('size') is-invalid @enderror" value="{{ $ogloszenie->size }}">
              @error('size')
                <span class="invalid-feedback" role="alert">
                      {{ $message }}
                  </span>
              @enderror
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

          <div class="form-group">
            {{ Form::label('to_negotiate', 'Cena do negocjacji') }}
            {{-- {{ Form::text('price', null, ['class' => 'form-control']) }} --}}
            <input type="checkbox" name="to_negotiate" value="{{ old('to_negotiate') }}">
          </div>

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
