@extends('layouts/app')

@section('content')

  @if(session('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('message') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif

  <div class="container searchbackground">
    <div class="searchbox-text">
      <h1>Znajdz mieszkanie w interesującej Cię okolicy</h1>
      <h2>Wpisz w wyszukiwarkę nazwę miejscowości lub dzielnicy.</h2>
    </div>
    <div class="search-group">
      <form id="action" class="form-inline">
      @csrf
      <div class="input-group-prepend">
        <input type="text" name="search" id="search" class="form-control"/>
        <input type="image" src="{{asset('img/lupa.png')}}" class="form-control"/>
      </div>

      </form>
    </div>
  </div>

<div id="data_result">
  @include('pages/ogloszenia/ajax_search')
</div>

<script type="application/javascript">
$(document).ready(function(){
 function fetch_data(query, sort_by, page){
  $.ajax({
   url:"/search?query="+query+"&sort_by="+sort_by+"&page="+page,

   success:function(data)
   {
    $('#data_result').html('');
    $('#data_result').html(data);
   }
 });
 }

$('#action').submit(function(event){
  // event.preventDefault(); // wylaczyc to

  var query = $('#search').val();
  var elementExists = document.getElementById("sort_by");
  if(elementExists){
    var sort_by = $('#sort_by').val();
  }else{
    var sort_by = 'created_at_desc';
  }
  if(query){
  fetch_data(query, sort_by);
  }
  return false;
 });

  $(document).on('change', '#sort_by', function(){
    var query = $('#search').val();
    var sort_by = $('#sort_by').val();
    fetch_data(query, sort_by);
  });

  $(document).on('click', '.pagination a', function(event){
   event.preventDefault();
   var page = $(this).attr('href').split('page=')[1];
   var query = $('#search').val();
   var sort_by = $('#sort_by').val();
   fetch_data(query, sort_by, page);
  });
});
</script>
@endsection
