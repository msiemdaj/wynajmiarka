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

  <div class="container">
  	<ul class="tabs">
  		<li class="tab-link current" data-tab="received">Odebrane</li>
  		<li class="tab-link" data-tab="sent">Wysłane</li>
  	</ul>

  	<div id="tabreceived" class="tab-content current">
      <h1>Odebrane wiadomości</h1>
      @if (count($messages_received) == 0)
        <div class="empty-mailbox">
          <img class="" src="{{asset('img/brakmsg.png')}}">
        </div>
      @else

      <form method="get" action="/wiadomosci/skrzynkaoptions">
        <div class="msg-options">
          <div class="zaznaczWszystko">
            <input type="checkbox" name="checkAll" class="checkAll" id="checkReceived">
            <label for='checkReceived'>Zaznacz wszystko</label>
          </div>
            <input type="image" src="{{asset('img/bin32.png')}}" name="deletesubmit" class="skrzynka-options-btn skrzynka-btn-del">
            <input type="image" src="{{asset('img/openemail32.png')}}" name="setReaded" id="setReaded" class="skrzynka-options-btn">
            <input type="image" src="{{asset('img/closedemail32.png')}}" name="setUnreaded" id="setUnreaded" class="skrzynka-options-btn">
        </div>

      <table class="table messages-table">
        <tbody>
      @foreach($messages_received as $wiadomosc)
        @if($wiadomosc->deleted_by_receiver == false)
        <tr class="row-link" data-href="/wiadomosci/{{ $wiadomosc->id }}"
          @if($wiadomosc->viewed == false)
            id="new-message"
          @endif
          >
            <td class="t-checkbox"> <input type="checkbox" @if($wiadomosc->viewed == false) class="checkbox-group current unreaded-message" @else class="checkbox-group current readed-message" @endif value="{{$wiadomosc->id}}" name="checkedMessage[]"> </td>
            <td class="t-name"> Od: {{ $wiadomosc->name }} </td>
            <td class="t-title">
              @if($wiadomosc->viewed == false)
                <b>{{ $wiadomosc->title }}</b>
              @else
                {{ $wiadomosc->title }}
              @endif
            </td>
            <td class="t-body">{{ $wiadomosc->message_body }}</td>
            <td class="t-date">
              <div class="name-group">
                {{ date('d/m/Y', strtotime($wiadomosc->sent_at)) }}
              </div>

              <div class="btn-group">
                @if($wiadomosc->viewed == true)
                  <a href="{{url('/wiadomosci/'.$wiadomosc->id.'/changeviewedstatus')}}"><img src="{{asset('img/closedemail16.png')}}"></a>
                @elseif($wiadomosc->viewed == false)
                  <a href="{{url('/wiadomosci/'.$wiadomosc->id.'/changeviewedstatus')}}"><img src="{{asset('img/openemail16.png')}}"></a>
                @endif
                  <a href="{{url('/wiadomosci/'.$wiadomosc->id.'/delete')}}"><img src="{{asset('img/bin16.png')}}"></a>
              </div>
            </td>
        </tr>
        @endif
      @endforeach
      </form>
      </tbody>
    </table>
    @endif
  	</div>
  	<div id="tabsent" class="tab-content">
      <h1>Wysłane wiadomości</h1>
      @if (count($messages_sent) == 0)
        <div class="empty-mailbox">
          <img class="" src="{{asset('img/brakmsg.png')}}">
        </div>
      @else
      <form method="get" action="/wiadomosci/skrzynkaoptions">
        <div class="msg-options">
          <div class="zaznaczWszystko">
            <input type="checkbox" name="checkAll" class="checkAll" id="checkSent">
            <label for='checkSent'>Zaznacz wszystko</label>
          </div>
          <input type="image" src="{{asset('img/bin32.png')}}" name="deletesubmit" class="skrzynka-options-btn skrzynka-btn-del">
        </div>

      <table class="table messages-table">
        <tbody>
        @foreach($messages_sent as $wiadomosc)
          @if($wiadomosc->deleted_by_sender == false)
          <tr class="row-link" data-href="/wiadomosci/{{ $wiadomosc->id }}">
          <td class="t-checkbox"> <input type="checkbox" class="checkbox-group" value="{{$wiadomosc->id}}" name="checkedMessage[]"> </td>
          <td class="t-name"> Do: {{ $wiadomosc->name }} </td>
          <td class="t-title"> {{ $wiadomosc->title }} </td>
          <td class="t-body"> {{ $wiadomosc->message_body }} </td>
          <td class="t-date">
            <div class="name-group">
              {{ date('d/m/Y', strtotime($wiadomosc->sent_at)) }}
            </div>
            <div class="btn-group">
              <a href="{{url('/wiadomosci/'.$wiadomosc->id.'/delete')}}"><img src="{{asset('img/bin16.png')}}"></a>
            </div>
          </td>
        </tr>
        @endif
        @endforeach
      </form>
      </tbody>
      </table>
    @endif
  	</div>
  </div>

  <script type="application/javascript">
    $(document).ready(function(){
    $('ul.tabs li').click(function(){
      var tab = $(this).attr('data-tab');
      $(".checkbox-group").prop("checked", false);
      $(".checkAll").prop("checked", false);
      $('#setReaded').hide();
      $('#setUneaded').hide();

      $('ul.tabs li').removeClass('current');
      $('.tab-content').removeClass('current');
      $('.checkbox-group').removeClass('current');

      $(this).addClass('current');
        $("#tab"+tab).addClass('current');
        $('.tab-content.current').find('.checkbox-group').addClass('current');

      })
    })
    </script>

  <script type="application/javascript">
    jQuery(document).ready(function($) {
      $(".row-link").click(function() {
          window.location = $(this).data("href");
      });
    });
  </script>

  <script type="application/javascript">
    $('.btn-group').on('click', function(e){
         e.stopPropagation();
    });
    $('.checkbox-group').on('click', function(e){
         e.stopPropagation();
    });
  </script>

  <script type="application/javascript">
  var mq = window.matchMedia( "(min-width: 992px)" );
  if (mq.matches) {
    $('.row-link').hover(function(){
            $(this).find('.name-group').hide();
            $(this).find('.btn-group').show();
        }, function() {
            $(this).find('.btn-group').hide();
            $(this).find('.name-group').show();
    });
  }
  </script>

  <script type="application/javascript">
  $(document).ready(function(){
    $('.checkAll').click(function(){
      var checked = this.checked;
      $('input[type="checkbox"].checkbox-group.current').each(function() {
        this.checked = checked;
      });
    });
  });

  $(document).ready(function() {
    $('.checkbox-group').click(function(){
      var length = $('input.checkbox-group.current:checked').length;

      if (length > 0){
        $(".checkAll").prop("checked", true);

      }else if(length == 0){
        $(".checkAll").prop("checked", false);
      }

      if ($('.current.readed-message').is(':checked')){
        $('#setReaded').hide();
        $('#setUnreaded').show();
      }
      if ($('.current.unreaded-message').is(':checked')){
        $('#setUnreaded').hide();
        $('#setReaded').show();
      }
      if ($('.current.readed-message').is(':checked') && $('.current.unreaded-message').is(':checked')){
        $('#setUnreaded').hide();
        $('#setReaded').show();
      }
      if ($('.current.readed-message').is(':checked') || $('.current.unreaded-message').is(':checked')){
      }else{
        $('#setReaded').hide();
        $('#setUnreaded').hide();
      }
    });
  });
  </script>

  <script type="application/javascript">
    $('#checkReceived').click(function (){
      var unreaded = 0;
      var readed = 0;
      if ($(this).is(':checked')){

        $('input[type="checkbox"].checkbox-group.current').each(function() {
          if(this.className == 'checkbox-group current unreaded-message'){
            unreaded++;
          }
          if(this.className == 'checkbox-group current readed-message'){
            readed++;
          }
        });

        if (readed > 0 && unreaded == 0) {
            $('#setReaded').hide();
            $('#setUnreaded').show();
        }
        if (readed == 0 && unreaded > 0) {
            $('#setUnreaded').hide();
            $('#setReaded').show();
        }
        if (readed > 0 && unreaded > 0) {
            $('#setUnreaded').hide();
            $('#setReaded').show();
        }

      }else{
        $('#setReaded').hide();
        $('#setUnreaded').hide();
      }
    });
  </script>

@endsection
