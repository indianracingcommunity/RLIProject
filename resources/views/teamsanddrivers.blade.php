@extends('layout')

@section('body')

<div class="container bg-dark jumbotron"><hr>
  <h2 class="display-2 text-center p-2 font-weight-normal font-italic text-white" >Featured</h2><hr class="bg-info">
  <h1 class="display-4 p-3 font-italic  font-weight-bold text-white text-center">Our Teams</h1>
  <div class=" bg-dark rounded border border-danger row">

    <div class="col-3 text-center">
      <a href="/teams/mercedes"  id="key" name="key" class="btn btn-default my-3">
        <img src="{{url('/storage/img/teamlogos/merc.png')}}" height="90" /> 
      </a>
    </div>

    <div class="col-3 text-center">
      <a href="/teams/ferrari" id="key" name="key" class="btn btn-default my-3">
        <img src="{{url('/storage/img/teamlogos/ferrari.png')}}" height="90" /> 
      </a>
    </div>

    <div class="col-3 text-center">
      <a href="/teams/redbull" id="key" name="key" class="btn btn-default my-3">
        <img src="{{url('/storage/img/teamlogos/rbr.png')}}" height="80" /> 
      </a>
    </div>

    <div class="col-3 text-center">
      <a href="/teams/mclaren"  id="key" name="key"class="btn btn-default my-3">
        <img src="{{url('/storage/img/teamlogos/mclaren.png')}}" height="100" /> 
      </a>
    </div>

    <div class="col-3 text-center">
      <a href="/teams/renault" id="key" name="key" class="btn btn-default my-3">
        <img src="{{url('/storage/img/teamlogos/renault.png')}}" height="70" /> 
      </a>
    </div>

    <div class="col-3 text-center">
      <a href="/teams/haas" id="key" name="key" class="btn btn-default my-3">
        <img src="{{url('/storage/img/teamlogos/haas.png')}}" height="70" /> 
      </a>
    </div>

    <div class="col-3 text-center">
      <a href="/teams/rpoint" id="key" name="key" class="btn btn-default my-3">
        <img src="{{url('/storage/img/teamlogos/rpoint.png')}}" height="100" /> 
      </a>
    </div>

    <div class="col-3 text-center">
      <a href="/teams/alfa" id="key" name="key" class="btn btn-default my-3">
        <img src="{{url('/storage/img/teamlogos/alfa.png')}}" height="100" /> 
      </a>
    </div>

    <div class="col-3 text-center">
      <span>&nbsp</span>
    </div>

    <div class="col-3 text-center">
      <a href="/teams/toro" id="key" name="key" class="btn btn-default my-3">
        <img src="{{url('/storage/img/teamlogos/toro.png')}}" height="50" /> 
      </a>
    </div>

    <div class="col-3 text-center">
      <a href="/teams/williams" id="key" name="key" class="btn btn-default my-3">
        <img src="{{url('/storage/img/teamlogos/williams.png')}}" height="60" /> 
      </a>
    </div>
  </div>
</div>

    
@endsection