@extends('layout')

@section('body')
<style>
  
</style>

<div class="card">
    <div class="card-header my-5">
      Featured
    </div>
    <div class="card-body">
      <h1 class="card-title text-center">Teams</h1>
      <a href="/teams/mercedes"  id="key" name="key" class="btn btn-default my-3"><img src="{{url('/img/teamlogos/merc.png')}}" width="70" /> </a>
      <a href="/teams/ferrari" id="key" name="key" class="btn btn-default my-3"><img src="{{url('/img/teamlogos/ferrari.png')}}" width="80" /> </a>
      <a href="/teams/redbull" id="key" name="key" class="btn btn-default my-3"><img src="{{url('/img/teamlogos/rbr.png')}}" width="100" /> </a>
      <a href="/teams/mclaren"  id="key" name="key"class="btn btn-default my-3"><img src="{{url('/img/teamlogos/mclaren.png')}}" width="120" /> </a>
      <a href="/teams/renault" id="key" name="key" class="btn btn-default my-3"><img src="{{url('/img/teamlogos/renault.png')}}" width="70" /> </a>
      <a href="/teams/haas" id="key" name="key" class="btn btn-default my-3"><img src="{{url('/img/teamlogos/haas.png')}}" width="70" /> </a>
      <a href="/teams/rpoint" id="key" name="key" class="btn btn-default my-3"><img src="{{url('/img/teamlogos/rpoint.png')}}" width="70" /> </a>
      <a href="/teams/alfa" id="key" name="key" class="btn btn-default my-3"><img src="{{url('/img/teamlogos/alfa.jpg')}}" width="100" /> </a>
      <a href="/teams/toro" id="key" name="key" class="btn btn-default my-3"><img src="{{url('/img/teamlogos/toro.png')}}" width="70" /> </a>
      <a href="/teams/williams" id="key" name="key" class="btn btn-default my-3"><img src="{{url('/img/teamlogos/williams.png')}}" width="70" /> </a>



    </div>
  </div>

    
@endsection