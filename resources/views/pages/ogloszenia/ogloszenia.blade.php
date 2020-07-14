@extends('layouts/app')

@section('content')
{!! Form::open(['url' => 'testmultisubmit', 'method' => 'post', 'id' => 'offer-create']) !!}
  {!! Form::submit( 'Save', ['class' => 'btn btn-primary', 'name' => 'save'])!!}
  {!! Form::submit( 'Save draft', ['class' => 'btn btn-primary', 'name' => 'save-draft']) !!}
{!! Form::close() !!}
@endsection
