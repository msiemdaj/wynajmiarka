@extends('layouts.app')

@section('content')
<div class="container">

  @if(session('message'))
    <div class="alert alert-success alert-dismissible fade show spce-1-t-alert" role="alert">
    {{ session('message') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif

  <div class="favorite-ogloszenia">
    <div class="favorite-ogloszenia-header">
      <h2>Ulubione ogłoszenia</h2>
      <h4>Lista twoich ogłoszeń, które dodałeś do ulubionych. Możesz bezpośrednio przejść na stronę ogłoszenia klikając na zdjęcie lub jego tytuł. Jeśli chcesz usunąc je z ulubionych klliknij w ikonę serca.</h4>
    </div>

@if(!$favoriteOgloszenia->isEmpty())
    <div class="favorite-list">
      @foreach ($favoriteOgloszenia as $ulubione)
        <div class="favorite-item">
          <div class="fav-item">
            <div class="favorite-image">
              @php
                $coverImage = json_decode($ulubione->image);
              @endphp
              <a href="/ogloszenia/{{$ulubione->id}}">
                <img src="{{ asset('images/'.$ulubione->id.'/'.$coverImage[0]) }}">
              </a>
            </div>
            <div class="fav-item-detail">
                  <a href="/ogloszenia/{{$ulubione->id}}">{{ $ulubione->title }}</a>
            </div>
            <div class="fav-item-detail">
              <span class="fav-item-span">{{$ulubione->city}}</span>
            </div>
            <div class="fav-item-detail">
              <b>Metraż:</b> {{ $ulubione->size }} m<sup>2</sup>
            </div>
            <div class="fav-item-detail">
              <b>Cena:</b> {{ $ulubione->price.' zł' }}
              @if($ulubione->to_negotiate == true)
                <span class="badge badge-secondary">do negocjacji</span>
              @endif
            </div>

            @if($ulubione->isFavoritedBy(auth()->user()))
            <div id="favorite" data-id="{{ $ulubione->id }}">
                <a href="/ogloszenie/{{$ulubione->id}}/unfavorite"><i class="favorite large material-icons" id="favo{{$ulubione->id}}" data-toggle="tooltip" data-placement="top" title="Usuń z ulubionych">favorite</i></a>
            </div>
            @endif

            <script type="text/javascript">
            $(function () {
              $('[data-toggle="tooltip"]').tooltip({
                trigger : 'hover'
                });
              });
            </script>

          </div>
        </div>
      @endforeach
    </div>
    @if(count($favoriteOgloszenia) > 4)
    <div class="showhide">
      <span>Pokaż więcej</span>
    </div>

    <script type="text/javascript">
      $('.showhide').click(function(){
        $(this).toggleClass('showless');
        if($(this).hasClass('showless')){
          $(".favorite-item:nth-of-type(1) ~ .favorite-item").css("display", "block");
          $(this).html('Pokaż mniej');
        }else{
          $(".favorite-item:nth-of-type(1) ~ .favorite-item").css("display", "");
          $(this).html('Pokaż więcej');
        }
      });
    </script>
  @endif
  @else
    Nie posiadasz ulubionych ogłoszeń, w celu dodania do swojej listy kliknij ikonę serca na wyszukanym przez Ciebie ogłoszeniu.
    <hr>
  @endif
  </div>

  <div class="simpl-head">
    <h2>Twoje Ogłoszenia</h2>
    <h4>Przeglądaj, edytuj lub usuń dodane przez ciebie ogłoszenia.</h4>
  </div>

@if(count($ogloszenia) > 0)
<div class="dodaj-ogloszenie-btn">
  <a href="/ogloszenia/dodaj" class="ogloszenie-button-2">
    <span>Dodaj ogłoszenie</span>
  </a>
</div>
@endif

         @if(count($ogloszenia) > 0)
              <table class="table table-striped tw-ogl-tbl">
                <tr>
                  <th colspan="2">Ogłoszenie</th>
                  <th class="th-size">Metraż</th>
                  <th class="th-price">Cena</th>
                  <th class="th-buttons"></th>
                </tr>
                @foreach($ogloszenia as $ogloszenie)
                  @php
                    $imageArray = json_decode($ogloszenie->image);
                  @endphp
                  <tr>
                    <td class="td-cover-image">
                          <img src="{{ asset('images/'.$ogloszenie->id.'/'.$imageArray[0]) }}">
                    </td>
                    <td class="td-title">
                          <a href="/ogloszenia/{{$ogloszenie->id}}">{{ $ogloszenie->title }}</a>
                    </td>
                    <td class="td-size">{{ $ogloszenie->size }} m2</td>
                    <td class="td-price">{{ $ogloszenie->price }} zł
                      @if($ogloszenie->to_negotiate == true)
                        <span class="badge badge-secondary">do negocjacji</span>
                      @endif
                    <td class="img-td">
                      <a class="td-edit" href="/ogloszenia/{{ $ogloszenie->id }}/edit"><img src="{{asset('img/edit-tools.png')}}" border="0"></a>
                      <a class="td-delete"><img src="{{asset('img/rubbish-can.png')}}" border="0" data-toggle="modal" data-target="#deleteConfirmation{{$ogloszenie->id}}"></a>
                      {{-- modal --}}
                      <div class="modal fade" id="deleteConfirmation{{$ogloszenie->id}}" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{$ogloszenie->id}}" aria-hidden="true">
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
                      {{-- modal end --}}
                    </td>
                  </tr>
                @endforeach
              </table>
 @else
   <div class="empty-ogl">
     <h2>Aktualnie nie posiadasz żadnych ogłoszeń</h2>
     <a href="/ogloszenia/dodaj">Kliknij tutaj, aby dodać nowe ogłoszenie</a>
   </div>
 @endif

</div>
@endsection
