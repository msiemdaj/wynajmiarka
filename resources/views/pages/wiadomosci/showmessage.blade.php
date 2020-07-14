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

<div class="msg-option-container">
  <a href="{{ url('wiadomosci') }}" class="skrzynka-options-btn"><span class="arrow arrow-left"></span>Wróc do skrzynki</a>
  {{-- <button type="button" class="card-btn card-btn-del" data-toggle="modal" data-target="#deleteConfirmation">Usuń</button> --}}
  <input type="image" src="{{asset('img/bin32.png')}}" class="skrzynka-options-btn skrzynka-btn-del" data-toggle="modal" data-target="#deleteConfirmation">
  @if($wiadomosc->receiver_id == auth()->user()->id)
      {{-- <a href="{{url('/wiadomosci/'.$wiadomosc->id.'/viewed')}}" class="card-btn"><span>Oznacz jako nieprzeczytane</span></a> --}}
      <a href="{{url('/wiadomosci/'.$wiadomosc->id.'/viewed')}}" class="skrzynka-options-btn"><img src="{{asset('img/closedemail16.png')}}"></img></a>
  @endif
</div>

  {{-- modal --}}
  <div class="modal fade" id="deleteConfirmation" tabindex="-1" role="dialog" aria-labelledby="modalLabel{{$wiadomosc->id}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content-ms">
        <div class="modal-header-ms">Potwierdź operację
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body-ms">
          Czy na pewno chcesz usunąć tą wiadomość?
        </div>
        <div class="modal-footer-ms">
          <div class="modal-delete-btn">
            <a href="{{url('/wiadomosci/'.$wiadomosc->id.'/delete')}}" class="card-btn card-btn-del"><span>Usuń</span></a>
          </div>
          <button type="button" class="card-btn" data-dismiss="modal">Nie</button>
        </div>
      </div>
    </div>
  </div>

<div class="container">
  <div class="message-preview-content">
    <div class="title">
      {{ $wiadomosc->title }}
    </div>
    <div class="sender">
      @if($wiadomosc->receiver_id == auth()->user()->id)
        Od: {{$wiadomosc->sender_name}}
      @elseif($wiadomosc->sender_id == auth()->user()->id)
          Do: {{$wiadomosc->receiver_name}}
      @endif
    </div>
    <div class="sent_at">
      Wysłano: {{ $wiadomosc->sent_at }}
    </div>
    <div class="message_body">
      <span>{{ $wiadomosc->message_body }}</span>
    </div>

    @if($wiadomosc->receiver_id == auth()->user()->id)
      {{-- modal button --}}
      <button type="button" class="card-btn" data-toggle="modal" data-target="#sendMessage">Odpowiedz</button>
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
              {!! Form::open(['action' => ['MessagesController@replyMessage', $wiadomosc->id],
                              'method' => 'POST']) !!}
                              @csrf
              <div class="form-group">
              <h6>{{ Form::label('title', 'Temat wiadomości') }}</h6>
              {{ Form::text('title', $wiadomosc->title, ['class="form-control"']) }}
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
              <button type="button" class="card-btn card-btn" data-dismiss="modal">Zamknij</button>
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
  </div>
  </div>
@endsection
