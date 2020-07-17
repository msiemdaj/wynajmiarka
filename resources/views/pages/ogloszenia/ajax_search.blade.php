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
          {{ $ogloszenie->city.', '.$ogloszenie->district }}
        </div>
        <div class="ogl-description">
          {{ $ogloszenie->description }}
        </div>
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

  {{ $data->links() }}

  </div>
  @else
    <div class="search-result-message">
      <h1>{{ $message ?? '' }}</h1>
    </div>
  @endif
