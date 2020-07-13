@extends('layouts.app')
@section('content')

@for ($i =0 ; $i < count($data); $i++)
    Name : {{$data[$i]['user']['name']}} 
    <br>
    Season : {{$data[$i]['season']['game']}} 
    <br>
    Created at :  {{$data[$i]['created_at']}} 
    <br><br>
@endfor



@endsection