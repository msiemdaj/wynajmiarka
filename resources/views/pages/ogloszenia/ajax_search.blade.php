@if(isset($data))

  <div class="search-result-message">
    <h1>{{ $message ?? '' }}</h1>
  </div>

<div class="sort-options">
    <div class="sorting">
      <select id="sort_by" class="form-control">
        <option value="created_at_desc" @if($_GET['sort_by'] === 'created_at_desc') selected @endif>Najnowsze</option>
        <option value="price_asc" @if($_GET['sort_by'] === 'price_asc') selected @endif>Cena: najtańsze</option>
        <option value="price_desc" @if($_GET['sort_by'] === 'price_desc') selected @endif>Cena: najdroższe</option>
        <option value="title_asc" @if($_GET['sort_by'] === 'title_asc') selected @endif>Tytuł: A-Z</option>
        <option value="title_desc" @if($_GET['sort_by'] === 'title_desc') selected @endif>Tytuł: Z-A</option>
        <option value="size_asc" @if($_GET['sort_by'] === 'size_asc') selected @endif>Metraż: najmniejszy</option>
        <option value="size_desc" @if($_GET['sort_by'] === 'size_desc') selected @endif>Metraż: największy</option>
      </select>
    </div>
</div>

<div class="all-ogl-results">
  @foreach($data as $ogloszenie)
    <div class="ogl-result">
      <div class="ogl-image">
        @php
          $coverImage = json_decode($ogloszenie->image);
        @endphp
        <a href="/ogloszenia/{{$ogloszenie->id}}">
          <img src="{{ asset('images/'.$ogloszenie->id.'/'.$coverImage[0]) }}">
        </a>
        {{-- 262 --}}
      </div>
      <div class="ogl-info">
        <div class="ogl-title">
          <a href="/ogloszenia/{{$ogloszenie->id}}">{{ $ogloszenie->title }}</a>
        </div>
        <div class="ogl-place">
          {{$ogloszenie->city}}@if($ogloszenie->district){{', '.$ogloszenie->district}}@endif
@if($ogloszenie->street){{', '.$ogloszenie->street}}@endif
        </div>
        <div class="ogl-description">
          {{$ogloszenie->description}}
        </div>

        @if (Auth::check())
          @if (Auth::user()->email_verified_at)
            <div class="favoriteContainer" data-id="{{ $ogloszenie->id }}">
            @if(!$ogloszenie->isFavoritedBy(auth()->user()))
              <i class="favorite dodaj large material-icons" id="favo{{$ogloszenie->id}}" data-toggle="tooltip" data-placement="top" title="Dodaj do ulubionych">favorite_border</i>
            @else
              <i class="favorite large material-icons" id="favo{{$ogloszenie->id}}" data-toggle="tooltip" data-placement="top" title="Usuń z ulubionych">favorite</i>
            @endif
          </div>
          @endif
        @endif

        <div class="ogl-bttm">
          <div class="ogl-size">
            <b>Metraż:</b> {{ $ogloszenie->size }} m<sup>2</sup>
          </div>
          <div class="ogl-price">
            <b>Cena:</b> {{ $ogloszenie->price.' zł' }}
          </div>
          <div class="ogl-date">
            <small>Dodano: {{ $ogloszenie->created_at }}</small>
          </div>
        </div>
      </div>
    </div>
  @endforeach


{{-- AUTH CHECK --}}

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

          $('.favoriteContainer').click(function(){
              var id = $(this).data('id');

              $.ajax({
                 type:'POST',
                 url:'/favRequest',
                 data:{id:id},
                 success:function(data){
                   if(data){
                     const element = document.querySelector('#favo'+id);
                     $('#favo'+id).tooltip('hide');
                     if (element.classList.contains("dodaj")){
                       $('#favo'+id).replaceWith('<i class="favorite large material-icons" id="favo'+id+'" data-toggle="tooltip" data-placement="top" title="Usuń z ulubionych">favorite</i>');
                     }else{
                       $('#favo'+id).replaceWith('<i class="favorite dodaj large material-icons" id="favo'+id+'" data-toggle="tooltip" data-placement="top" title="Dodaj do ulubionych">favorite_border</i>');
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

  {{ $data->onEachSide(2)->links() }}

  </div>
  @else
    <div class="search-result-message">
      <h1>{{ $message ?? '' }}</h1>
    </div>
  @endif
