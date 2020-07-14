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

  <div class="simpl-head">
    <h2>Twoje Ogłoszenia</h2>
    <h4>Przeglądaj, edytuj lub usuń dodane przez ciebie ogłoszenia.</h4>
  </div>

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
                    <td class="td-price">{{ $ogloszenie->price }} zł</td>
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
