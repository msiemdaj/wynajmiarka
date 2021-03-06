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

  @if(session('errormessage'))
    <div class="alert alert-danger alert-dismissible fade show spce-1-t-alert" role="alert">
    {{ session('errormessage') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif
    <div class="container">
    <div class="ogloszenie-header-title">
      {{ $ogloszenie->title }}
    </div>
        <div class="ogloszenie-gallery-content">
          @if($ogloszenie->image)
            @php
            $imageArray = json_decode($ogloszenie->image);
            $flag = 0;
            @endphp
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" data-interval="false">
              <div class="carousel-inner" id="gallery-inner-main">
            @foreach ($imageArray as $imageName)
              @if($flag == 0)
                  {{-- <div class="cover-image" id="gallery" data-toggle="modal" data-target="#galleryModal">
                    <img src="{{ asset('images/'.$ogloszenie->id.'/'.$imageName) }}" data-target="#carouselExample" data-slide-to="{{$flag}}">
                  </div> --}}
                  <div class="carousel-item active" id="gallery" data-toggle="modal" data-target="#galleryModal">
                    <img class="d-block w-100" src="{{ asset('images/'.$ogloszenie->id.'/'.$imageName) }}" data-target="#carouselExample" data-slide-to="{{$flag}}">
                  </div>
              @else
                  {{-- <div class="all-photos" id="gallery" data-toggle="modal" data-target="#galleryModal">
                    <img src="{{ asset('images/'.$ogloszenie->id.'/'.$imageName) }}" data-target="#carouselExample" data-slide-to="{{$flag}}">
                  </div> --}}
                  <div class="carousel-item" id="gallery" data-toggle="modal" data-target="#galleryModal">
                    <img class="d-block w-100" src="{{ asset('images/'.$ogloszenie->id.'/'.$imageName) }}" data-target="#carouselExample" data-slide-to="{{$flag}}">
                  </div>
              @endif
              @php
                $flag++;
              @endphp
            @endforeach
          @endif

            </div>
          </div>

          <div class="gallery-nav">
            <a class="gallery-arrow-left" href="#carouselExampleControls" role="button" data-slide="prev"><span class="arrow arrow-left"></span></a>
            <div class="counter">
              <div class="slide-number"></div>
            </div>
            <a class="gallery-arrow-right" href="#carouselExampleControls" role="button" data-slide="next"><span class="arrow arrow-right"></a>
          </div>
      </div>

      @if(!empty($ogloszenie->equipment))
        @php
          $equipment = json_decode($ogloszenie->equipment);
        @endphp
      @endif

      @if(!empty($ogloszenie->additional_info))
        @php
          $additional_info = json_decode($ogloszenie->additional_info);
        @endphp
      @endif

<div class="ogloszenie-middle-content">
        <div class="ogloszenie-info-content">
          <div class="ogloszenie-info-container">
            <div class="ogloszenie-info-item">
              <h4>Miejscowość</h4>
              <h5> {{ $ogloszenie->city }} </h5>
            </div>
            @if($ogloszenie->district)
              <div class="ogloszenie-info-item">
                <h4>Dzielnica</h4>
                <h5> {{ $ogloszenie->district }} </h5>
              </div>
            @endif
            @if($ogloszenie->street)
              <div class="ogloszenie-info-item">
                <h4>Ulica / osiedle</h4>
                <h5> {{ $ogloszenie->street }} </h5>
              </div>
            @endif
            <div class="ogloszenie-info-item">
              <h4>Metraż</h4>
              <h5> {{ $ogloszenie->size }} m<sup>2</sup> </h5>
            </div>
            <div class="ogloszenie-info-item">
              <h4>Cena</h4>
              <h5> {{ $ogloszenie->price.' zł' }}
              @if($ogloszenie->to_negotiate == true)
                <span class="badge badge-secondary">do negocjacji</span>
              @endif
            </div>
            @if($ogloszenie->additional_costs)
              <div class="ogloszenie-info-item">
                <h4>Dodatkowy czynsz</h4>
                <h5> {{ $ogloszenie->additional_costs.' zł' }} </h5>
              </div>
            @endif
            @if($ogloszenie->deposit)
              <div class="ogloszenie-info-item">
                <h4>Kaucja</h4>
                <h5> {{ $ogloszenie->deposit.' zł' }} </h5>
              </div>
            @endif
            @if($ogloszenie->rooms)
              <div class="ogloszenie-info-item">
                <h4>Ilość pokoi</h4>
                <h5> {{ str_replace("_", " ", $ogloszenie->rooms) }} </h5>
              </div>
            @endif
            @if($ogloszenie->floor)
              <div class="ogloszenie-info-item">
                <h4>Piętro</h4>
                <h5> {{ str_replace("_", " ", $ogloszenie->floor) }} </h5>
              </div>
            @endif
            @if($ogloszenie->condition)
              <div class="ogloszenie-info-item">
                <h4>Stan mieszkania</h4>
                <h5> {{ str_replace("_", " ", $ogloszenie->condition) }} </h5>
              </div>
            @endif
            @if($ogloszenie->heating)
              <div class="ogloszenie-info-item">
                <h4>Ogrzewanie</h4>
                <h5> {{ str_replace("_", " ", $ogloszenie->heating) }} </h5>
              </div>
            @endif
            @if($ogloszenie->year_of_construction)
              <div class="ogloszenie-info-item">
                <h4>Rok budowy</h4>
                <h5> {{ $ogloszenie->year_of_construction }} </h5>
              </div>
            @endif
            </div>
            @if(!empty($ogloszenie->equipment) or !empty($ogloszenie->additional_info))
            <div class="additional-info-container">
            @if(!empty($ogloszenie->equipment))
              <div class="ogloszenie-info-additional">
                <h4>Wyposażenie</h4>
                @foreach ($equipment as $equipmentItem)
                  <h5><i class="check-icon material-icons">check</i> {{ str_replace("_", " ", $equipmentItem) }}</h5>
                @endforeach
              </div>
            @endif
            @if(!empty($ogloszenie->additional_info))
              <div class="ogloszenie-info-additional">
                <h4>Dodatkowe informacje</h4>
                @foreach ($additional_info as $additional_infoItem)
                  <h5><i class="check-icon material-icons">check</i> {{ str_replace("_", " ", $additional_infoItem) }}</h5>
                @endforeach
              </div>
            @endif
          </div>
          @endif
          </div>

        <div class="ogloszenie-options-btn">
            @if (Auth::check())
                  @if(Auth::id() == $ogloszenie->user_id)

                      <a class="ogloszenie-button-1" href="/ogloszenia/{{ $ogloszenie->id }}/edit"><span>Edytuj ogłoszenie</span></a>
                      <a class="ogloszenie-button-2" data-toggle="modal" data-target="#deleteConfirmation"><span>Usuń ogłoszenie</span></a>


                    {{-- <button class="ogloszenie-button-1" type="button" data-toggle="modal" data-target="#deleteConfirmation">Usuń ogłoszenie</button> --}}

                    {{-- modal --}}
                    <div class="modal fade" id="deleteConfirmation" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{$ogloszenie->id}}" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content-ms">
                          <div class="modal-header-ms">Potwierdź operację
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body-ms">
                            Czy na pewno chcesz usunąć to ogłoszenie? Jeśli potwierdzisz operację nie będziesz już w stanie przywrócić tego ogłoszenia na tablicę.
                          </div>
                          <div class="modal-footer-ms">
                            {!! Form::open(['action' => ['OgloszeniaController@destroy', $ogloszenie->id],
                                            'method' => 'DELETE']) !!}
                            {{ Form::submit('Tak, usuń ogłoszenie', ['class' => 'card-btn card-btn-del']) }}
                            {!! Form::close() !!}
                            <button type="button" class="card-btn" data-dismiss="modal">Nie</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  @else

                    <div class="ogloszenie-phone-num">
                    @if(!empty($ogloszenie->user->phonenumber))
                      <span>Numer telefonu</span>
                      <span>{{ $ogloszenie->user->phonenumber }}</span>
                    @else
                        <span>Użytkownik nie podał numeru telefonu</span>
                    @endif
                    </div>
                    {{-- modal button --}}
                    <a class="ogloszenie-button-2" data-toggle="modal" data-target="#sendMessage"><span>Napisz wiadomość</span></a>
                    {{-- <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#sendMessage">Napisz wiadomość</button> --}}
                    {{-- modal --}}
                    <div class="modal fade" id="sendMessage" tabindex="-1" role="dialog" aria-labelledby="sendMsgLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content-ms">
                          <div class="modal-header-ms">Wyślij wiadomość
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body-ms">
                            {{-- form --}}
                            {!! Form::open(['action' => ['MessagesController@sendMessage', $ogloszenie->id],
                                            'method' => 'POST']) !!}
                                            @csrf
                            <div class="form-group">
                            <h6>{{ Form::label('title', 'Temat wiadomości') }}</h6>
                            {{ Form::text('title', null, ['class="form-control"']) }}
                            </div>
                            <div class="form-group">
                            <h6>{{ Form::label('message_body', 'Treść wiadomości') }}</h6>
                            {{ Form::textarea('message_body', null, ['class="form-control"']) }}
                            </div>
                            {{-- end of form --}}

                          </div>
                          <div class="modal-footer-ms">
                            {{ Form::submit('Wyślij wiadomość', ['class' => 'card-btn card-btn-confirm', 'id' => 'send-msg']) }}
                            {!! Form::close() !!}
                            <button type="button" class="card-btn" data-dismiss="modal">Zamknij</button>
                          </div>
                          <script type="application/javascript">
                          $(function(){
                            $('#send-msg').click(function(){
                                $($(this)).prop('disabled', true);
                                $(this.form).submit()
                            });
                          });
                          </script>
                        </div>
                      </div>
                    </div>
                    {{-- modal end --}}
                  @endif
            @else
              <a class="ogloszenie-button-1" href="/ogloszenia/{{$ogloszenie->id}}/showcontact"><span>Zaloguj się, aby zobaczyć numer telefonu</span></a>
              <a class="ogloszenie-button-2" href="/ogloszenia/{{$ogloszenie->id}}/showcontact"><span>Zaloguj się, zby wysłać wiadomość</span></a>
            @endif
        </div>
      </div>

        <div class="ogloszenie-description-content">
          <h4>Opis ogłoszenia</h4>
          <span>{{ $ogloszenie->description }}</span>
          <hr>
          <small>Dodano: {{ $ogloszenie->created_at }}</small>

          @if (Auth::check())
            @if (Auth::user()->email_verified_at)
          <div id="favorite" data-id="{{ $ogloszenie->id }}">
            @if(!$ogloszenie->isFavoritedBy(auth()->user()))
              <i class="favorite dodaj large material-icons" id="favo{{$ogloszenie->id}}" data-toggle="tooltip" data-placement="top" title="Dodaj do ulubionych">favorite_border</i>
            @else
              <i class="favorite large material-icons" id="favo{{$ogloszenie->id}}" data-toggle="tooltip" data-placement="top" title="Usuń z ulubionych">favorite</i>
            @endif
          </div>
        @endif
      @endif
        </div>

        @if (Auth::check())
          @if (Auth::user()->email_verified_at)
        {{-- add to favorite --}}
              <script type="text/javascript">
              $(function () {
                $('[data-toggle="tooltip"]').tooltip({
                  trigger : 'hover'
                  });
                });
              </script>

              <script type="text/javascript">
                  $(document).ready(function() {

                      $.ajaxSetup({
                          headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          }
                      });

                      $('#favorite').click(function(){
                          var id = $('#favorite').data('id');

                          $.ajax({
                             type:'POST',
                             url:'/favRequest',
                             data:{id:id},
                             success:function(data){
                               if(data){
                                 const element = document.querySelector('#favo'+id);
                                 $('#favo'+id).tooltip('hide');
                                 if (element.classList.contains("dodaj")){
                                   $('#favo'+id).replaceWith('<i class="favorite large material-icons" id="favo{{$ogloszenie->id}}" data-toggle="tooltip" data-placement="top" title="Usuń z ulubionych">favorite</i>');
                                 }else{
                                   $('#favo'+id).replaceWith('<i class="favorite dodaj large material-icons" id="favo{{$ogloszenie->id}}" data-toggle="tooltip" data-placement="top" title="Dodaj do ulubionych">favorite_border</i>');
                                 }
                                 $('#favo'+id).tooltip({
                                   trigger : 'hover'
                                   });
                               }
                             }
                          });
                      });
                  });
              </script>
            @endif
          @endif
        {{-- add to favorite --}}

  </div>

<div class="modal fade bd-example-modal-xl" id="galleryModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div id="carouselExample" class="carousel slide" data-ride="carousel">
          <ol class="carousel-indicators">
            @for ($i=0; $i < $flag; $i++)
              @if ($i == 0)
                <li data-target="#carouselExample" data-slide-to="{{ $i }}" class="active"></li>
                @else
                  <li data-target="#carouselExample" data-slide-to="{{ $i }}"></li>
              @endif
            @endfor
          </ol>
          <div class="carousel-inner">
            @if($ogloszenie->image)
            @php
              $flag = 0;
            @endphp
            @foreach ($imageArray as $imageName)
              @if ($flag == 0)
                <div class="carousel-item active">
                  <img class="d-block w-100" src="{{ asset('images/'.$ogloszenie->id.'/'.$imageName) }}">
                </div>
                @else
                  <div class="carousel-item">
                    <img class="d-block w-100" src="{{ asset('images/'.$ogloszenie->id.'/'.$imageName) }}">
                  </div>
              @endif
              @php
                $flag++;
              @endphp
            @endforeach
            @endif
          </div>
          <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>
    </div>
  </div>
</div>

<script type="application/javascript">
  var totalSlides = $('#carouselExampleControls .carousel-item').length;
  var currSlide = $('#carouselExampleControls div.active').index() + 1;
  $('.slide-number').html('Zdjęcie ' + currSlide + ' z ' + totalSlides + '');

  $(document).ready(function(){
    $('#carouselExampleControls').on('slid.bs.carousel', function() {
      currSlide = $('#carouselExampleControls div.active').index() + 1;
      $('.slide-number').html('Zdjęcie ' + currSlide + ' z ' + totalSlides + '');
       });
  });
</script>
@endsection
